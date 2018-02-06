<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accreditation;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\Building;
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
        $this->validate($request,[
            'building_id' => 'required|not_in:0',
            'accreditation_requirement_id' => 'required|not_in:0'
        ]);

        $building = Building::find($request->building_id);
        $accreditation = Accreditation::find($accreditation_id);
        $accreditation_requirement = AccreditationRequirement::find($request->accreditation_requirement_id);
        return view('accreditation.index',['accreditation' => $accreditation,'accreditation_requirement' => $accreditation_requirement,'building' => $building]);
    }

    public function fetchBuildings(Request $request)
    {
        $site = Site::find($request->site_id);

        return response()->json(['buildings' => $site->buildings]);

    }

    public function fetchSites(Request $request)
    {
        $hco = HCO::find($request->hco_id);

        return response()->json(['sites' => $hco->sites]);

    }
}
