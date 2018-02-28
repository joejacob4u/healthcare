<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\EOP;
use App\Regulatory\EOPFinding;
use App\Regulatory\Building;
use App\Regulatory\HealthSystem;
use App\Regulatory\AccreditationRequirement;
use Session;

class EOPStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($eop_id)
    {
        $eop = EOP::find($eop_id);
        $building = Building::find(session('building_id'));
        $findings = EOPFinding::orderBy('id','desc')->get();
        return view('accreditation.status',['eop' => $eop,'building' => $building,'findings' => $findings]);
    }

    public function addFinding($eop_id)
    {
        $eop = EOP::find($eop_id);
        return view('accreditation.finding.add',['eop' => $eop]);
    }

    public function createFinding(Request $request)
    {
        $this->validate($request,[
            'description' => 'required',
            'plan_of_action' => 'required',
            'measure_of_success' => 'required',
            'status' => 'required',
            'location' => 'required'
        ]);

        if(EOPFinding::create($request->all()))
        {
            return redirect('system-admin/accreditation/eop/status/'.$request->eop_id)->with('success','New finding added!');
        }

    }


}
