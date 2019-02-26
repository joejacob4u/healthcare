<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\DemandWorkOrder;
use App\Equipment\IlsmAssessment;
use App\Equipment\IlsmQuestion;
use Auth;

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
}
