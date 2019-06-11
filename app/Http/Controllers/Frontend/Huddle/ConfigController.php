<?php

namespace App\Http\Controllers\Frontend\Huddle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Huddle\Config;
use App\Huddle\Tier;
use App\Regulatory\HCO;
use App\Regulatory\Site;
use App\Huddle\CareTeam;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $huddle_configs = Config::where('healthsystem_id', session('healthsystem_id'))->orderBy('created_at', 'desc')->paginate(25);
        $care_teams = CareTeam::where('healthsystem_id', session('healthsystem_id'))->orderBy('created_at', 'desc')->paginate(25);
        return view('huddle.index', ['huddle_configs' => $huddle_configs, 'care_teams' => $care_teams]);
    }

    public function create()
    {
        $care_teams = CareTeam::pluck('name', 'id');
        $hcos = HCO::where('healthsystem_id', session('healthsystem_id'))->pluck('facility_name', 'id');
        $tiers = Tier::pluck('name', 'id');
        $users = \App\User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');
        return view('huddle.add', ['hcos' => $hcos, 'tiers' => $tiers, 'users' => $users, 'care_teams' => $care_teams]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'care_team_id' => 'required',
            'hco_id' => 'required',
            'site_id' => 'required',
            'building_id' => 'required',
            'department_id' => 'required',
            'schedule' => 'required',
            'time' => 'required',
            'location' => 'required',
            'leader_user_id' => 'required',
            'alternative_leader_user_id' => 'required',
            'recorder_of_data_user_id' => 'required',
            'alternative_recorder_of_data_user_id' => 'required'
        ]);

        if ($config = Config::create($request->all())) {
            $config->reportToCareTeams()->sync($request->care_teams);
            return redirect('system-admin/huddle/configs')->with('success', 'New Huddle Config created!');
        }
    }

    public function edit(Config $huddle_config)
    {
        $hcos = HCO::where('healthsystem_id', session('healthsystem_id'))->pluck('facility_name', 'id');
        $tiers = Tier::pluck('name', 'id');
        $users = \App\User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');
        return view('huddle.edit', ['hcos' => $hcos, 'tiers' => $tiers, 'users' => $users, 'huddle_config' => $huddle_config]);
    }

    public function save(Request $request, Config $huddle_config)
    {
        $this->validate($request, [
            'care_team_id' => 'required',
            'hco_id' => 'required',
            'site_id' => 'required',
            'building_id' => 'required',
            'department_id' => 'required',
            'schedule' => 'required',
            'time' => 'required',
            'location' => 'required',
            'leader_user_id' => 'required',
            'alternative_leader_user_id' => 'required',
            'recorder_of_data_user_id' => 'required',
            'alternative_recorder_of_data_user_id' => 'required'
        ]);

        if ($huddle_config->update($request->all())) {
            return redirect('system-admin/huddle/configs')->with('success', 'Huddle Config updated!');
        }
    }

    public function delete(Request $request)
    {
        if (Config::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }

    public function fetchReportToCareTeams(Request $request)
    {
        $care_team = CareTeam::find($request->care_team_id);

        if ($care_team->tier_id == 2 || $care_team->tier_id == 3) {

            //fetch all tier 1 care teams
            $care_teams = CareTeam::where('tier_id', ($care_team->tier_id - 1))->get();
            return response()->json(['status' => 'success', 'user_select' => true, 'care_teams' => $care_teams]);
        } else {
            return response()->json(['status' => 'success', 'user_select' => false]);
        }
    }
}
