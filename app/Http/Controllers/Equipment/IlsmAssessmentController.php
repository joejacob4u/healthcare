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
            $this->createChecklists($ilsm_assessment);
            return back()->with('success', 'ILSM Question Approved');
        }
    }

    public function ilsmChecklist(Request $request)
    {
        $is_compliant = 1;


        foreach ($request->answers as $key => $answer) {
            if (empty($answer['answer']) and $key != 'attachment') {
                return back()->with('warning', 'Please answer all questions on checklist and try again.');
            }

            if ($key != 'attachment' and $answer['answer'] == 'no') {
                dd($answer);
                $is_compliant = 0;
            }
        }

        $ilsm_checklist = IlsmChecklist::find($request->ilsm_checklist_id);

        $request->request->add(['is_answered' => 1,'is_compliant' => $is_compliant]);

        if ($ilsm_checklist->update($request->all())) {
            $ilsm_assessment = IlsmAssessment::find($request->ilsm_assessment_id);
            
            if ($ilsm_assessment->isChecklistComplete()) {
                $ilsm_assessment->update(['ilsm_assessment_status_id' => 6]);
            }
            return back()->with('success', 'A checklist has been completed.');
        }
    }

    private function createChecklists(IlsmAssessment $ilsm_assessment)
    {
        //loop thru each question answer first
        foreach ($ilsm_assessment->applicableIlsms() as $ilsm_id) {
            $ilsm = Ilsm::find($ilsm_id);

            $dates = [];

            if (!in_array($ilsm->frequency, ['one-time','shift-quarterly','shift'])) {
                switch ($ilsm->frequency) {
                    case 'daily':
                        $interval = 'P1D';
                        break;
        
                    case 'weekly':
                        $interval = 'P1W';
                        break;
        
                    case 'monthly':
                        $interval = 'P1M';
                        break;
        
                    case 'quarterly':
                        $interval = 'P3M';
                        break;
                }

                
        
                $from = new DateTime($ilsm_assessment->start_date);
        
                $to = new DateTime($ilsm_assessment->end_date);
        
                $interval = new DateInterval($interval);
                
                $periods = new DatePeriod($from, $interval, $to);
        
                foreach ($periods as $period) {
                    $dates[] = $period->format('Y-m-d');
                }
            } else {
                $dates[] = date('Y-m-d');
            }

            //insert each one by one

            foreach ($dates as $date) {
                $ilsm_assessment->checklists()->create([
                    'ilsm_id' => $ilsm_id,
                    'date' => $date
                ]);
            }
        }
    }
}
