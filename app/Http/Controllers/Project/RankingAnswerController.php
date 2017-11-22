<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project\RankingQuestion;
use App\Project\RankingAnswer;


class RankingAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($question_id)
    {
        $question = RankingQuestion::find($question_id);
        $answers = RankingAnswer::get();
        return view('project.questions.answers',['question' => $question,'answers' => $answers]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'answer' => 'required',
            'score' => 'required'
        ]);

        $question = RankingQuestion::find($request->question_id);
        $question->answers()->save(new RankingAnswer(['answer' => $request->answer,'score' => $request->score]));
        return back()->with('success','Answer added!');
    }

    public function save(Request $request)
    {
        $this->validate($request,[
            'answer' => 'required',
            'score' => 'required'
        ]);

        $answer = RankingAnswer::find($request->answer_id);

        if($answer->update(['answer' => $request->answer,'score' => $request->score]))
        {
            return response()->json([
                'answer' => $request->answer,
                'id' => $request->answer_id,
                'score' => $request->score
            ]);
        }
    }

    public function delete(Request $request)
    {
        if(RankingAnswer::destroy($request->answer_id))
        {
            return $request->answer_id;
        }

    }
}
