<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Ilsm;
use App\Equipment\IlsmChecklistQuestion;

class IlsmChecklistQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index($ilsm_id)
    {
        $ilsm = Ilsm::find($ilsm_id);
        return view('admin.ilsm.checklist.index', ['ilsm' => $ilsm]);
    }

    public function store(Request $request, $ilsm_id)
    {
        $this->validate($request, [
            'question'
        ]);

        $ilsm = Ilsm::find($ilsm_id);

        if ($ilsm->ilsmChecklistQuestions()->create($request->all())) {
            return back()->with('success', 'Checklist question successfully created.');
        }
    }

    public function delete(Request $request)
    {
        $ilsm_checklist_question = IlsmChecklistQuestion::find($request->ilsm_checklist_question_id);

        if ($ilsm_checklist_question->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
