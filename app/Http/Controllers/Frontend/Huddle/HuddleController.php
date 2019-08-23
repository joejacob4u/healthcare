<?php

namespace App\Http\Controllers\Frontend\Huddle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Huddle\Huddle;
use App\User;
use App\Huddle\CareTeam;
use Auth;
use App\Equipment\IlsmAssessment;
use App\Equipment\DemandWorkOrder;
use App\Assessment\Assessment;
use App\Equipment\BaselineDate;
use App\Equipment\Inventory;
use App\Equipment\PreventiveMaintenanceWorkOrder;

class HuddleController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $huddles = Huddle::orderByDesc('date')->paginate(25);
        return view('huddle.user.index', ['huddles' => $huddles]);
    }

    public function create()
    {
        $care_teams = CareTeam::where('recorder_of_data_user_id', Auth::user()->id)->orWhere('alternative_recorder_of_data_user_id', Auth::user()->id)->pluck('name', 'id');
        $users = User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');
        return view('huddle.user.add', ['users' => $users, 'care_teams' => $care_teams]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'care_team_id' => 'required',
            'attendance' => 'required',
            'date' => 'required',
            'has_no_capacity_constraint' => 'required'
        ]);

        if ($huddle = Huddle::create($request->except(['attendance']))) {
            $huddle->users()->sync(array_except($request->attendance, [0, '']));
            return redirect('huddle')->with('success', 'New huddle created.');
        }
    }

    public function view(Huddle $huddle)
    {
        $users = User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');

        //get pm based on inventory

        //get all inventory first
        $inventory = Inventory::whereIn('department_id', $huddle->careTeam->departments->pluck('id'))->get();
        $pm_work_orders = PreventiveMaintenanceWorkOrder::whereIn('baseline_date_id', $inventory->pluck('baseline_date_id'))->get();


        //calculate all dm ids for that building to fetch ilsm assessments
        $demand_work_orders = DemandWorkOrder::whereIn('building_department_id', $huddle->careTeam->departments->pluck('id'))->get();

        $ilsm_assessments = IlsmAssessment::where(function ($query) use ($demand_work_orders) {
            $query->whereIn('work_order_id', $demand_work_orders->pluck('id'))->where('work_order_type', 'App\Equipment\DemandWorkOrder');
        })->orWhere(function ($query) use ($pm_work_orders) {
            $query->whereIn('work_order_id', $pm_work_orders->pluck('id'))->where('work_order_type', 'App\Equipment\PreventiveMaintenanceWorkOrder');
        })->paginate(50);

        $assessments = Assessment::whereIn('building_department_id', $huddle->careTeam->departments->pluck('id'))->get();
        return view('huddle.user.view', ['huddle' => $huddle, 'users' => $users, 'ilsm_assessments' => $ilsm_assessments, 'assessments' => $assessments]);
    }

    public function save(Request $request, Huddle $huddle)
    {
        $this->validate($request, [
            'attendance' => 'required',
        ]);

        if ($huddle->update($request->except(['attendance']))) {
            $huddle->users()->sync(array_except($request->attendance, [0, '']));
            return back()->with('success', 'Huddle saved.');
        }
    }
}
