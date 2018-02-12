<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accreditation;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\EOP;
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
        Session::put('building_id', $building->id);
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

    public function eopDocumentation($eop_id)
    {
        $building = Building::find(session('building_id'));
        $eop = EOP::find($eop_id);
        $last_submission = $eop->getLastDocumentUpload(session('building_id'));
        return view('accreditation.documentation',['building' => $building,'eop' => $eop]);
    }

    public function uploadEOPDocument(Request $request)
    {
        $this->validate($request,[
            'submission_date' => 'required',
        ]);

        $building = Building::find($request->building_id);

        if($building->eopDocumentations()->sync([$request->eop_id => ['accreditation_id' => $request->accreditation_id, 'document_path' => $request->document_path, 'submission_date' => $request->submission_date, 'user_id' => $request->user_id]]))
        {
            return back()->with('success','Document Added!');
        } 

    }
}
