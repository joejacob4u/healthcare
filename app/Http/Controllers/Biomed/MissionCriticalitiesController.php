<?php

namespace App\Http\Controllers\Biomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Biomed\MissionCriticality;

class MissionCriticalitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('biomed.mission-criticality', ['mission_criticalities' => MissionCriticality::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:biomed_mission_criticalities,name',
            'score' => 'required|numeric'
        ]);

        if (MissionCriticality::create($request->all())) {
            return back()->with('success', 'Misssion Criticality created!');
        }
    }

    public function delete(Request $request)
    {
        MissionCriticality::destroy($request->id);
        return 'true';
    }
}
