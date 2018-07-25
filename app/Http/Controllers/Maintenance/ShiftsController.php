<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HealthSystem;
use Auth;
use App\Maintenance\Shift;

class ShiftsController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_admin');
    }

    public function index()
    {
        $shifts = Shift::whereIn('hco_id', Healthsystem::find(Auth::user()->healthsystem_id)->hcos->pluck('id'))->get();
        return view('maintenance.shifts.index', ['shifts' => $shifts]);
    }

    public function create()
    {
        $healthsystem = HealthSystem::find(Auth::user()->healthsystem_id);
        return view('maintenance.shifts.add', ['healthsystem' => $healthsystem]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'hco_id' => 'required|exists:hco,id',
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        if ($shift = Shift::create($request->except(['period_start_time','period_end_time','period_description']))) {
            if (!empty($request->period_start_time)) {
                $period_start_time = $request->period_start_time;
                $period_end_time = $request->period_end_time;
                $period_description = $request->period_description;
    
                foreach ($period_start_time as $key => $value) {
                    $shift->periods()->create(['start_time' => $period_start_time[$key],'end_time' => $period_end_time[$key],'description' => $period_description[$key]]);
                }
            }
            
            return back()->with('success', 'Success');
        }
    }

    public function edit(Request $request, $id)
    {
        $shift = Shift::find($id);
        $healthsystem = HealthSystem::find(Auth::user()->healthsystem_id);
        return view('maintenance.shifts.edit', ['shift' => $shift,'healthsystem' => $healthsystem]);
    }

    public function save(Request $request, $id)
    {
        $this->validate($request, [
            'hco_id' => 'required|exists:hco,id',
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $shift = Shift::find($id);

        if ($shift->update($request->except(['period_start_time','period_end_time','period_description']))) {
            if (!empty($request->period_start_time)) {
                $period_start_time = $request->period_start_time;
                $period_end_time = $request->period_end_time;
                $period_description = $request->period_description;
                $shift->periods()->delete();

    
                foreach ($period_start_time as $key => $value) {
                    $shift->periods()->create(['start_time' => $period_start_time[$key],'end_time' => $period_end_time[$key],'description' => $period_description[$key]]);
                }
            }
            
            return back()->with('success', 'Success');
        }
    }
}
