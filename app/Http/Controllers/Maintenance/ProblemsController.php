<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\Trade;
use App\Maintenance\Problem;

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
            'name' => 'required|unique:maintenance_problems,name'
        ]);

        $trade = Trade::find($trade_id);

        if ($trade->problems()->create($request->all())) {
            return back()->with('success', 'New problem added.');
        }
    }

    public function delete(Request $request)
    {
        Problem::destroy($request->problem_id);
    }
}
