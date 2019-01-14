<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Trade;
use App\Equipment\Problem;

class ProblemsController extends Controller
{
    public function index($trade_id)
    {
        $trade = Trade::find($trade_id);
        return view('maintenance.problems.index', ['trade' => $trade]);
    }

    public function store(Request $request, $trade_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'priority' => 'not_in:0'
        ]);

        $trade = Trade::find($trade_id);

        if ($trade->problems()->create($request->all())) {
            return back()->with('success', 'New problem added.');
        }
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'priority' => 'not_in:0'
        ]);

        $problem = Problem::find($request->problem_id);

        if ($problem->update($request->except(['problem_id']))) {
            return back()->with('success', 'Problem updated!');
        }
    }


    public function delete(Request $request)
    {
        Problem::destroy($request->problem_id);
    }
}
