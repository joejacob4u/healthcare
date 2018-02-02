<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accreditation;
use App\Regulatory\HCO;
use App\Regulatory\HealthSystem;
use App\Regulatory\AccreditationRequirement;
use Session;
use Auth;

class AccreditationController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($accreditation_id)
    {
        Session::put('accreditation_id', $accreditation_id);
        $accreditation = Accreditation::find($accreditation_id);
        return view('accreditation.index',['accreditation' => $accreditation]);

    }

    public function fetchAccrRequirements(Request $request,$accreditation_id)
    {
        $accreditation = Accreditation::find($accreditation_id);
        $accreditation_requirement = AccreditationRequirement::find($request->accreditation_requirement_id);
        return view('accreditation.index',['accreditation' => $accreditation,'accreditation_requirement' => $accreditation_requirement]);
    }

    public function fetchBuildings(Request $request)
    {
        $hco = HCO::find($request->hco_id);

        $buildings = [];

        foreach($hco->sites as $site)
        {
            if(!empty($site->buildings))
            {
                $buildings[$site->name] = $site->buildings->pluck('name','id')->toArray(); 
            }
        }

        return $buildings;
    }

    public function fetchSites(Request $request)
    {
        $hco = HCO::find($request->hco_id);

        return response()->json(['sites' => $hco->sites]);

    }
}
