<?php

namespace App\Http\Controllers\Admin\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Assessment\Category;
use App\Regulatory\EOP;
use App\SystemTier;
use App\Assessment\Question;
use App\Equipment\Trade;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index(Category $category)
    {
        return view('admin.assessment.questions', ['category' => $category]);
    }

    public function create(Category $category)
    {
        $eops = EOP::get(['name', 'text', 'id'])->pluck('full_name', 'id');
        $system_tiers = SystemTier::pluck('name', 'id');
        return view('admin.assessment.question-add', ['category' => $category, 'eops' => $eops, 'system_tiers' => $system_tiers]);
    }

    public function store(Request $request, Category $category)
    {
        $this->validate($request, [
            'question' => 'required',
            'system_tier_id' => 'required',
            'work_order_trade_id' => 'required',
            'work_order_problem_id' => 'required',
            'answers' => 'required|array',
            'answers.*' => 'required|distinct|min:1'
        ]);

        if (!isset($request->answers['negative'])) {
            return back()->with('warning', 'Negative answer needs to be set.');
        }

        if ($category->questions()->create($request->all())) {
            return back()->with('success', 'Question created!');
        }
    }

    public function edit(Category $category, Question $question)
    {
        $eops = EOP::get(['name', 'text', 'id'])->pluck('full_name', 'id');
        $system_tiers = SystemTier::pluck('name', 'id');
        return view('admin.assessment.question-edit', ['category' => $category, 'eops' => $eops, 'system_tiers' => $system_tiers, 'question' => $question]);
    }

    public function update(Request $request, Category $category, Question $question)
    {
        $this->validate($request, [
            'question' => 'required',
            'system_tier_id' => 'required',
            'work_order_trade_id' => 'required',
            'work_order_problem_id' => 'required',
            'answers' => 'required|array',
            'answers.*' => 'required|distinct|min:1'
        ]);

        if ($question->update($request->all())) {
            return back()->with('success', 'Question updated!');
        }
    }

    public function destroy(Request $request)
    {
        if (Question::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }

    public function fetchTrades(Request $request)
    {
        $system_tier = SystemTier::find($request->system_tier_id);
        return response()->json(['trades' => $system_tier->trades]);
    }

    public function fetchProblems(Request $request)
    {
        $trade = Trade::find($request->work_order_trade_id);
        return response()->json(['problems' => $trade->problems]);
    }
}
