<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project\RankingQuestion;

class RankingQuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $questions = RankingQuestion::get();
        return view('project.questions.index',['questions' => $questions]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'question' => 'required'
        ]);

        if(RankingQuestion::create($request->all()))
        {
            return back()->with('success','Question Added!');
        }
    }

    public function save(Request $request)
    {
        $this->validate($request,[
            'question' => 'required'
        ]);

        $question = RankingQuestion::find($request->question_id);

        if($question->update(['question' => $request->question]))
        {
            return response()->json([
                'question' => $request->question,
                'id' => $request->question_id
            ]);
        }


    }
}
