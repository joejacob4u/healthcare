<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Trade;
use App\Equipment\Problem;
use App\Equipment\PreventiveMaintenanceWorkOrderPriority;

class ProblemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('master')->except(['fetchProblems']);
    }

    public function index($trade_id)
    {
        $trade = Trade::find($trade_id);
        $work_order_priorities = WorkOrderPriority::pluck('name', 'id');
        return view('maintenance.problems.index', ['trade' => $trade,'work_order_priorities' => $work_order_priorities]);
    }

    public function store(Request $request, $trade_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'work_order_priority_id' => 'not_in:0'
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
            'work_order_priority_id' => 'not_in:0'
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

    public function fetchProblems(Request $request)
    {
        $problems = Problem::with('priority')->where('work_order_trade_id', $request->trade_id)->get();
        return response()->json(['status' => 'success','problems' => $problems]);
    }
}
