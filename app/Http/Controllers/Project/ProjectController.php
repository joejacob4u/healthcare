<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project\Project;
use App\Project\CapitalProjectType;
use App\Regulatory\HCO;
use App\Regulatory\Site;
use App\Regulatory\Building;
use App\Contractors;
use App\Regulatory\HealthSystem;
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

    public function createGeneral()
    {
        $health_system = HealthSystem::find(Auth::guard('system_user')->user()->healthsystem_id);
        $hcos = HCO::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->pluck('facility_name','id');
        $project_types = CapitalProjectType::pluck('name','id');
        return view('project.add',['hcos' => $hcos,'project_types' => $project_types,'health_system' => $health_system]);
    }

    public function storeGeneral(Request $request)
    {
        if($project = Project::create($request->except('buildings')))
        {
            if(!empty($request->buildings))
            {
                foreach($request->buildings as $building)
                {
                    $aBuildings[] = Building::find($building);
                }
    
                $project->buildings()->saveMany($aBuildings);
            }

            return redirect('projects')->with('success','Project created.');
        }
    }

    public function editGeneral($project_id)
    {
        $project = Project::find($project_id);
        $sites = Site::where('hco_id',$project->hco_id)->pluck('name','id');
        $buildings = Building::where('site_id',$project->site_id)->pluck('name','id');
        $health_system = HealthSystem::find(Auth::guard('system_user')->user()->healthsystem_id);
        $hcos = HCO::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->pluck('facility_name','id');
        $project_types = CapitalProjectType::pluck('name','id');
        return view('project.edit',['hcos' => $hcos,'project_types' => $project_types,'health_system' => $health_system,'project' => $project,'buildings' => $buildings,'sites' => $sites]);
    }

    public function saveGeneral(Request $request,$project_id)
    {
        $project = Project::find($project_id);

        if($project->update($request->except('buildings')))
        {
            if(!empty($request->buildings))
            {
                foreach($request->buildings as $building)
                {
                    $aBuildings[] = Building::find($building);
                }
    
                $project->buildings()->sync($aBuildings);
            }

            return redirect('projects')->with('success','Project edited.');

        }
    }

    public function saveCON(Request $request,$project_id)
    {
        $project = Project::find($project_id);

        if($project->update($request->all()))
        {
            return back()->with('success','Project CON saved.');
        }
    }

    public function saveFinancial(Request $request,$project_id)
    {
        $project = Project::find($project_id);

        if($project->update($request->all()))
        {
            return back()->with('success','Project CON saved.');
        }

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
