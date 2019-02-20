<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Ilsm;
use App\Equipment\IlsmQuestion;

class IlsmQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index($ilsm_id)
    {
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'ilsms' => 'required|array'
        ]);

        if ($question = IlsmQuestion::create($request->all())) {
            if ($question->ilsms()->sync($request->ilsms)) {
                return redirect('/admin/ilsms#ilsm-questions')->with('success', 'New question created.');
            }
        }
    }

    public function delete(Request $request)
    {
        $ilsm_question = IlsmQuestion::find($request->ilsm_question_id);

        if ($ilsm_question->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
