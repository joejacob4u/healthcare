<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\EOP;
use App\Regulatory\EOPFinding;
use App\Regulatory\EOPFindingComment;
use App\Regulatory\Building;
use App\Regulatory\HealthSystem;
use App\Regulatory\AccreditationRequirement;
use App\User;
use Auth;
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

    public function editFinding($eop_id,$finding_id)
    {
        $finding = EOPFinding::find($finding_id);
        $eop = EOP::find($eop_id);
        return view('accreditation.finding.edit',['finding' => $finding,'eop' => $eop]);
    }

    public function saveFinding(Request $request,$eop_id,$finding_id)
    {
        $this->validate($request,[
            'description' => 'required',
            'plan_of_action' => 'required',
            'measure_of_success' => 'required',
            'status' => 'required',
            'location' => 'required'
        ]);

        $finding = EOPFinding::find($finding_id);

        if($finding->update($request->all()))
        {
            return redirect('system-admin/accreditation/eop/status/'.$request->eop_id)->with('success','Finding saved!');
        }

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

    public function viewFinding($eop_id,$finding_id)
    {
        $eop = EOP::find($eop_id);
        $finding = EOPFinding::find($finding_id);
        $building = Building::find(session('building_id'));
        $healthsystem_users = User::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->pluck('name','id')->prepend('Please select a user', '0');
        return view('accreditation.finding.finding',['eop' => $eop,'building' => $building,'finding' => $finding,'healthsystem_users' => $healthsystem_users]);
    }

    public function createComment(Request $request)
    {
        $this->validate($request,[
            'comment' => 'required',
            'due_date' => 'required',
            'assigned_user_id' => 'not_in:0'
        ]);

        $finding = EOPFinding::find($request->eop_finding_id);

        if(EOPFindingComment::create($request->all()))
        {
            $finding->update(['status' => $request->status]);
            return back()->with('success','Comment has been added!');
        }
    }
}
