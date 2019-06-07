<?php

namespace App\Http\Controllers\Frontend\Huddle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Huddle\Config;
use App\Huddle\Tier;
use App\Regulatory\HCO;
use App\Regulatory\Site;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $huddle_configs = Config::where('healthsystem_id', session('healthsystem_id'))->orderBy('created_at', 'desc')->paginate(25);
        return view('huddle.index', ['huddle_configs' => $huddle_configs]);
    }

    public function create()
    {
        $hcos = HCO::where('healthsystem_id', session('healthsystem_id'))->pluck('facility_name', 'id');
        $tiers = Tier::pluck('name', 'id');
        $users = \App\User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');
        return view('huddle.add', ['hcos' => $hcos, 'tiers' => $tiers, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'hco_id' => 'required',
            'site_id' => 'required',
            'building_id' => 'required',
            'department_id' => 'required',
            'huddle_tier_id' => 'required',
            'schedule' => 'required',
            'time' => 'required',
            'leader_user_id' => 'required',
            'alternative_leader_user_id' => 'required',
            'recorder_of_data_user_id' => 'required',
            'alternative_recorder_of_data_user_id' => 'required'
        ]);

        if (Config::create($request->all())) {
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
            'hco_id' => 'required',
            'site_id' => 'required',
            'building_id' => 'required',
            'department_id' => 'required',
            'huddle_tier_id' => 'required',
            'schedule' => 'required',
            'time' => 'required',
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
}
