<?php

namespace App\Http\Controllers\Frontend\Huddle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Huddle\CareTeam;
use App\Huddle\Tier;
use App\Regulatory\HCO;
use App\Regulatory\Site;

class CareTeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function create()
    {
        $tiers = Tier::pluck('name', 'id');
        $hcos = HCO::where('healthsystem_id', session('healthsystem_id'))->pluck('facility_name', 'id');
        $users = \App\User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');

        return view('huddle.care-team.add', ['tiers' => $tiers, 'hcos' => $hcos, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'tier_id' => 'required',
            'site_id' => 'required_if:tier_id,1',
            'hco_id' => 'required_if:tier_id,1',
            'building_id' => 'required_if:tier_id,1',
            'department_id' => 'required_if:tier_id,1',
            'location' => 'required',
            'leader_user_id' => 'required',
            'alternative_leader_user_id' => 'required',
            'recorder_of_data_user_id' => 'required',
            'alternative_recorder_of_data_user_id' => 'required',
            'report_to_care_teams' => 'required_unless:tier_id,1'
        ]);

        if ($care_team = CareTeam::create($request->all())) {

            if ($request->tier_id == 1) {
                //lets save all hco,site,building and department info
                $care_team->hcos()->sync([$request->hco_id]);
                $care_team->sites()->sync([$request->site_id]);
                $care_team->buildings()->sync([$request->building_id]);
                $care_team->departments()->sync([$request->department_id]);
            } else {

                //all the care teams it reports to
                $report_to_care_teams = CareTeam::whereIn('id', $request->report_to_care_teams)->get();

                $care_team_hco_ids = [];
                $care_team_site_ids = [];
                $care_team_building_ids = [];
                $care_team_department_ids = [];

                foreach ($report_to_care_teams as $report_to_care_team) {
                    foreach ($report_to_care_team->hcos as $hco) {
                        $care_team_hco_ids[] = $hco->id;
                    }

                    foreach ($report_to_care_team->sites as $site) {
                        $care_team_site_ids[] = $site->id;
                    }

                    foreach ($report_to_care_team->buildings as $building) {
                        $care_team_building_ids[] = $building->id;
                    }

                    foreach ($report_to_care_team->departments as $department) {
                        $care_team_department_ids[] = $department->id;
                    }
                }

                $care_team->hcos()->sync(array_unique($care_team_hco_ids));
                $care_team->sites()->sync(array_unique($care_team_site_ids));
                $care_team->buildings()->sync(array_unique($care_team_building_ids));
                $care_team->departments()->sync(array_unique($care_team_department_ids));
            }

            return redirect('system-admin/huddle/configs#care-teams')->with('success', 'New Care Team created.');
        }
    }

    public function edit(CareTeam $care_team)
    {
        $tiers = Tier::pluck('name', 'id');
        $hcos = HCO::where('healthsystem_id', session('healthsystem_id'))->pluck('facility_name', 'id');
        $report_to_care_teams = CareTeam::where('healthsystem_id', session('healthsystem_id'))->where('tier_id', $care_team->tier_id)->pluck('name', 'id');
        $users = \App\User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');
        return view('huddle.care-team.edit', ['care_team' => $care_team, 'tiers' => $tiers, 'report_to_care_teams' => $report_to_care_teams, 'hcos' => $hcos, 'users' => $users]);
    }

    public function update(Request $request, CareTeam $care_team)
    {
        $this->validate($request, [
            'name' => 'required',
            'tier_id' => 'required',
            'site_id' => 'required_if:tier_id,1',
            'hco_id' => 'required_if:tier_id,1',
            'building_id' => 'required_if:tier_id,1',
            'department_id' => 'required_if:tier_id,1',
            'location' => 'required',
            'leader_user_id' => 'required',
            'alternative_leader_user_id' => 'required',
            'recorder_of_data_user_id' => 'required',
            'alternative_recorder_of_data_user_id' => 'required',
            'report_to_care_teams' => 'required_unless:tier_id,1'
        ]);

        if ($care_team->update($request->all())) {

            if ($request->tier_id == 1) {
                //lets save all hco,site,building and department info
                $care_team->hcos()->sync([$request->hco_id]);
                $care_team->sites()->sync([$request->site_id]);
                $care_team->buildings()->sync([$request->building_id]);
                $care_team->departments()->sync([$request->department_id]);
            } else {

                //all the care teams it reports to
                $report_to_care_teams = CareTeam::whereIn('id', $request->report_to_care_teams)->get();

                $care_team_hco_ids = [];
                $care_team_site_ids = [];
                $care_team_building_ids = [];
                $care_team_department_ids = [];

                foreach ($report_to_care_teams as $report_to_care_team) {
                    foreach ($report_to_care_team->hcos as $hco) {
                        $care_team_hco_ids[] = $hco->id;
                    }

                    foreach ($report_to_care_team->sites as $site) {
                        $care_team_site_ids[] = $site->id;
                    }

                    foreach ($report_to_care_team->buildings as $building) {
                        $care_team_building_ids[] = $building->id;
                    }

                    foreach ($report_to_care_team->departments as $department) {
                        $care_team_department_ids[] = $department->id;
                    }
                }

                $care_team->hcos()->sync(array_unique($care_team_hco_ids));
                $care_team->sites()->sync(array_unique($care_team_site_ids));
                $care_team->buildings()->sync(array_unique($care_team_building_ids));
                $care_team->departments()->sync(array_unique($care_team_department_ids));
            }

            return redirect('system-admin/huddle/configs#care-teams')->with('success', 'Care Team updated.');
        }
    }

    public function delete(Request $request)
    {
        if (CareTeam::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }

    public function fetchCareTeams(Request $request)
    {
        $tier = Tier::find(($request->tier_id - 1));
        return response()->json(['care_teams' => $tier->careTeams]);
    }
}
