<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project\Project;
use App\Project\CapitalProjectType;
use App\Regulatory\HCO;
use App\Regulatory\Site;
use App\Regulatory\Building;
use Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $projects = Project::get();
        return view('project.index',['projects' => $projects]);
    }

    public function create()
    {
        $hcos = HCO::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->pluck('facility_name','id');
        $project_types = CapitalProjectType::pluck('name','id');
        return view('project.add',['hcos' => $hcos,'project_types' => $project_types]);
    }

    public function fetchSites(Request $request)
    {
        $sites = Site::where('hco_id',$request->hco_id)->get();
        return response()->json(['sites' => $sites]);

    }

    public function fetchBuildings(Request $request)
    {
        $buildings = Building::where('site_id',$request->site_id)->get();
        return response()->json(['buildings' => $buildings]);

    }

}
