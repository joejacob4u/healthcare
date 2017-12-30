<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Workflow\AccreditationComplianceLeader;

class AccreditationComplianceLeaderController extends Controller
{

    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $accreditation_compliance_leaders = AccreditationComplianceLeader::get();
        return view('workflow.accreditation-compliance-leaders.index',['accreditation_compliance_leaders' => $accreditation_compliance_leaders]);
    }

    public function create()
    {
        return view('workflow.accreditation-compliance-leaders.add');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'title' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if(AccreditationComplianceLeader::create($request->all()))
        {
            return redirect('workflows/accreditation-compliance-leaders')->with('success','New Accreditation Compliance Leader added!');
        }
    }

    public function edit($accreditation_compliance_leader)
    {
        $accreditation_compliance_leader = AccreditationComplianceLeader::find($accreditation_compliance_leader);
        return view('workflow.accreditation-compliance-leaders.edit',['accreditation_compliance_leader' => $accreditation_compliance_leader]);
    }

    public function save(Request $request,$accreditation_compliance_leader)
    {
        $this->validate($request,[
            'name' => 'required',
            'title' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $accreditation_compliance_leader = AccreditationComplianceLeader::find($accreditation_compliance_leader);

        if($accreditation_compliance_leader->update($request->all()))
        {
            return redirect('workflows/accreditation-compliance-leaders')->with('success','Accreditation Compliance Leader saved');
        }
    }

    public function delete(Request $request)
    {
        if(AccreditationComplianceLeader::destroy($request->accreditation_compliance_leader_id))
        {
            return redirect('workflows/accreditation-compliance-leaders')->with('success','Accreditation Compliance Leader deleted');
        }
    }
    
}
