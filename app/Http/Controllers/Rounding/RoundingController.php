<?php

namespace App\Http\Controllers\Rounding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rounding\Rounding;
use Illuminate\Support\Facades\Storage;

class RoundingController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $roundings = Rounding::where('building_id', session('building_id'))->paginate(30);
        return view('rounding.rounding.index', ['roundings' => $roundings]);
    }

    public function questions(Rounding $rounding)
    {
        return view('rounding.rounding.questions', ['rounding' => $rounding]);
    }

    public function saveQuestions(Request $request, Rounding $rounding)
    {
        // $this->validate($request, [
        //     'answers.*.answer' => 'required'
        // ]);

        $answers = [];
        $is_negative = 0;

        foreach ($request->answers as $key => $answer) {
            if ($answer['answer'] == $answer['negative']) {
                $is_negative = 1;
                //check if comment and attachment is set
                if (empty($answer['comment'])) {
                    return back()->with('warning', 'Comment required for question '.$key);
                }

                $files = Storage::disk('s3')->files($answer['attachment']);
                if (count($files) == 0) {
                    return redirect('/roundings')->with('warning', 'Attachment for question '.$key);
                }
            }

            $answers[$key] = $answer;
        }

        if ($rounding->update(['answers' => $answers,'rounding_status_id' => ($is_negative) ? 4 : 3])) {
            return back()->with('success', 'Questions completed!');
        }
    }
}
