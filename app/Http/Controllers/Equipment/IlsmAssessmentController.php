<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\DemandWorkOrder;
use App\Equipment\IlsmAssessment;
use App\Equipment\IlsmQuestion;
use Auth;
use App\Equipment\Ilsm;
use App\Equipment\IlsmChecklist;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Maintenance\Shift;
use Storage;

class IlsmAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function view($ilsm_assessment_id)
    {
        $ilsm_assessment = IlsmAssessment::find($ilsm_assessment_id);
        $ilsm_questions = IlsmQuestion::get();
        return view('equipment.work-order.ilsm-assessment', ['ilsm_assessment' => $ilsm_assessment,'ilsm_questions' => $ilsm_questions]);
    }

    public function ilsmPreAssessment(Request $request)
    {
        $answers = $request->ilsm_preassessment_question_answers;

        $demand_work_order = DemandWorkOrder::find($request->demand_work_order_id);

        if ($answers[1] == 1 || $answers[3] == 1) {
            $demand_work_order->ilsmAssessment()->update([
                'ilsm_assessment_status_id' => 3,
                'ilsm_preassessment_question_answers' => json_encode($answers),
                'ilsm_preassessment_user_id' => $request->ilsm_preassessment_user_id
            ]);
        } else {
            $demand_work_order->ilsmAssessment()->update([
                'ilsm_assessment_status_id' => 2,
                'ilsm_preassessment_question_answers' => json_encode($answers),
                'ilsm_preassessment_user_id' => $request->ilsm_preassessment_user_id
            ]);
        }

        return back();
    }

    public function ilsmQuestions(Request $request)
    {
        $this->validate($request, [
            'ilsm_question_answers.*' => 'required',
        ]);

        $ilsm_assessment = IlsmAssessment::find($request->ilsm_assessment_id);

        if ($ilsm_assessment->update(['ilsm_question_answers' => $request->ilsm_question_answers,'ilsm_question_user_id' => Auth::user()->id,'ilsm_assessment_status_id' => 4])) {
            return back();
        }
    }

    public function ilsmQuestionApprove(Request $request)
    {
        $this->validate($request, [
            'end_date' => 'required',
        ]);

        $ilsm_assessment = IlsmAssessment::find($request->ilsm_assessment_id);

        if ($ilsm_assessment->update($request->all())) {
            $this->createChecklists($ilsm_assessment, $request->user_id);
            return back()->with('success', 'ILSM Question Approved');
        }
    }

    public function ilsmChecklist(Request $request)
    {
        $ilsm_checklist = IlsmChecklist::find($request->ilsm_checklist_id);

        $is_compliant = 1;

        foreach ($request->answers as $key => $answer) {
            if (empty($answer['answer']) and $key != 'attachment') {
                return back()->with('warning', 'Please answer all questions on checklist and try again.');
            }

            if ($key != 'attachment' and $answer['answer'] == 'no') {
                $is_compliant = 0;
            }

            if ($key == 'attachment' and $ilsm_checklist->ilsm->attachment_required) {
                $files = Storage::disk('s3')->files($answer);
                if (count($files) == 0) {
                    return back()->with('warning', 'Attachment required! Try again.');
                }
            }
        }


        $request->request->add(['is_answered' => 1,'is_compliant' => $is_compliant]);

        if ($ilsm_checklist->update($request->all())) {
            $ilsm_assessment = IlsmAssessment::find($request->ilsm_assessment_id);
            
            if ($ilsm_assessment->isChecklistComplete()) {
                $ilsm_assessment->update(['ilsm_assessment_status_id' => 6]);
            } else {
                $ilsm_assessment->update(['ilsm_assessment_status_id' => 5]);
            }
            return back()->with('success', 'A checklist has been completed.');
        }
    }

    public function adjustEndDate(Request $request)
    {
        $ilsm_assessment = IlsmAssessment::find($request->ilsm_assessment_id);

        if ($ilsm_assessment->update($request->all())) {
            $this->createChecklists($ilsm_assessment, $request->user_id);
            return back();
        }
    }

    public function signOff(Request $request)
    {
        $ilsm_assessment = IlsmAssessment::find($request->ilsm_assessment_id);

        if ($ilsm_assessment->update($request->all())) {
            return back();
        }
    }

    private function createChecklists(IlsmAssessment $ilsm_assessment, $user_id)
    {
        $existing_checklists = $ilsm_assessment->checklists;

        //loop thru each question answer first
        foreach ($ilsm_assessment->applicableIlsms() as $ilsm_id) {
            $ilsm = Ilsm::find($ilsm_id);

            $dates = [];
            $is_shift = false;


            if (!in_array($ilsm->frequency, ['one-time','shift-quarterly','shift'])) {
                $is_existant = false;

                switch ($ilsm->frequency) {
                    case 'daily':
                        $interval = 'P1D';
                        $is_existant = true;
                        break;
        
                    case 'weekly':
                        $interval = 'P1W';
                        $is_existant = true;
                        break;
        
                    case 'monthly':
                        $interval = 'P1M';
                        $is_existant = true;
                        break;
        
                    case 'quarterly':
                        $interval = 'P3M';
                        $is_existant = true;
                        break;
                }

                if ($is_existant) {
                    $from = new DateTime($ilsm_assessment->start_date);
        
                    $to = new DateTime($ilsm_assessment->end_date);
            
                    $interval = new DateInterval($interval);
                    
                    $periods = new DatePeriod($from, $interval, $to);
            
                    foreach ($periods as $period) {
                        if ($existing_checklists->where('ilsm_id', $ilsm->id)->where('ilsm_assessment_id', $ilsm_assessment->id)->where('date', 'like', '%' . $period->format('Y-m-d') . '%')->where('shift_id', 0)->count() < 1) {
                            $dates[] = $period->format('Y-m-d');
                        }
                    }
                } else {
                    if ($existing_checklists->where('ilsm_id', $ilsm->id)->where('ilsm_assessment_id', $ilsm_assessment->id)->where('date', 'like', '%' . $period->format('Y-m-d') . '%')->where('shift_id', 0)->count() < 1) {
                        $dates[] = date('Y-m-d', strtotime('+1 day'));
                    }
                }
            } else {
                $ar = ['' => 'Please Select','one-time' => 'One Time','shift' => 'One Time per Shift','daily-per-shift' => 'Daily Per Shift','daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly','quarterly' => 'Quarterly','quarterly-shift' => 'Quarterly per Shift'];

                if ($ilsm->frequency == 'shift') {
                    //do for one day but for all shifts
                    $day = strtolower(strftime('%A', strtotime('+1 day')));
                    //get all maintenance shifts
                    $maintenance_shifts = Shift::where('hco_id', session('hco_id'))->where('days', 'LIKE', '%'.$day.'%')->get();

                    foreach ($maintenance_shifts as $maintenance_shift) {
                        $is_shift = true;
                        $dates[$maintenance_shift->id] = date('Y-m-d', strtotime('+1 day'));
                    }
                }

                if ($ilsm->frequency == 'daily-per-shift') {
                    $from = new DateTime($ilsm_assessment->start_date);
        
                    $to = new DateTime($ilsm_assessment->end_date);
            
                    $interval = new DateInterval('P1D');
                    
                    $periods = new DatePeriod($from, $interval, $to);
            
                    foreach ($periods as $period) {
                        $date = $period->format('Y-m-d');
                        //do for one day but for all shifts
                        $day = strtolower(strftime('%A', $date));
                        //get all maintenance shifts

                        $maintenance_shifts = Shift::where('hco_id', session('hco_id'))->where('days', 'LIKE', '%'.$day.'%')->get();

                        foreach ($maintenance_shifts as $maintenance_shift) {
                            $is_shift = true;
                            if ($existing_checklists->where('ilsm_id', $ilsm->id)->where('ilsm_assessment_id', $ilsm_assessment->id)->where('date', 'like', '%' . $period->format('Y-m-d') . '%')->where('shift_id', $maintenance_shift->id)->count() < 1) {
                                $dates[$maintenance_shift->id] = $date;
                            }
                        }
                    }
                }

                if ($ilsm->frequency == 'quarterly-per-shift') {
                    $from = new DateTime($ilsm_assessment->start_date);
        
                    $to = new DateTime($ilsm_assessment->end_date);
            
                    $interval = new DateInterval('P3M');
                    
                    $periods = new DatePeriod($from, $interval, $to);
            
                    foreach ($periods as $period) {
                        $date = $period->format('Y-m-d');
                        //do for one day but for all shifts
                        $day = strtolower(strftime('%A', $date));
                        //get all maintenance shifts

                        $maintenance_shifts = Shift::where('hco_id', session('hco_id'))->where('days', 'LIKE', '%'.$day.'%')->get();

                        foreach ($maintenance_shifts as $maintenance_shift) {
                            $is_shift = true;
                            if ($existing_checklists->where('ilsm_id', $ilsm->id)->where('ilsm_assessment_id', $ilsm_assessment->id)->where('date', 'like', '%' . $period->format('Y-m-d') . '%')->where('shift_id', $maintenance_shift->id)->count() < 1) {
                                $dates[$maintenance_shift->id] = $date;
                            }
                        }
                    }
                }



                //if empty
                if (empty($dates)) {
                    $dates[0] = date('Y-m-d', strtotime('+1 day'));
                }
            }

            //insert each one by one

            foreach ($dates as $key => $date) {
                $ilsm_assessment->checklists()->create([
                    'ilsm_id' => $ilsm_id,
                    'date' => $date,
                    'shift_id' => ($is_shift) ? $key : 0,
                    'user_id' => $user_id
                ]);
            }
        }
    }
}
