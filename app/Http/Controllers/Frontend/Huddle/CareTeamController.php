<?php

namespace App\Http\Controllers\Frontend\Huddle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Huddle\CareTeam;
use App\Huddle\Tier;

class CareTeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function create()
    {
        $tiers = Tier::pluck('name', 'id');
        return view('huddle.care-team.add', ['tiers' => $tiers]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'tier_id' => 'required'
        ]);

        if (CareTeam::create($request->all())) {
            return redirect('system-admin/huddle/configs#care-teams')->with('success', 'New Care Team created.');
        }
    }

    public function edit(CareTeam $care_team)
    {
        $tiers = Tier::pluck('name', 'id');
        return view('huddle.care-team.edit', ['care_team' => $care_team, 'tiers' => $tiers]);
    }

    public function update(Request $request, CareTeam $care_team)
    {
        $this->validate($request, [
            'name' => 'required',
            'tier_id' => 'required'
        ]);

        if ($care_team->update($request->all())) {
            return redirect('system-admin/huddle/configs#care-teams')->with('success', 'Care Team updated.');
        }
    }

    public function delete(Request $request)
    {
        if (CareTeam::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
