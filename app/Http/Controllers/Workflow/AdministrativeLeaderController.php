<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Workflow\AdministrativeLeader;
use App\Workflow\ApprovalLevelLeader;

class AdministrativeLeaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $administrative_leaders = AdministrativeLeader::get();
        return view('workflow.administrative-leader.index',['administrative_leaders' => $administrative_leaders]);
    }

    public function create()
    {
        $approval_level_leaders = ApprovalLevelLeader::pluck('title','id');
        return view('workflow.administrative-leader.add',['approval_level_leaders' => $approval_level_leaders]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'workflow_approval_level_leader_id' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if(ApprovalLevelLeader::create($request->all()))
        {
            return redirect('workflows/administrative-leaders')->with('success','New Administrative Leader added!');
        }
    }

    public function edit($administrative_leader)
    {
        $administrative_leader = AdministrativeLeader::find($administrative_leader);
        $approval_level_leaders = ApprovalLevelLeader::pluck('title','id');
        return view('workflow.administrative-leader.edit',['approval_level_leaders' => $approval_level_leaders,'administrative_leader' => $administrative_leader]);
    }

    public function save(Request $request,$administrative_leader)
    {
        $this->validate($request,[
            'name' => 'required',
            'workflow_approval_level_leader_id' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $administrative_leader = AdministrativeLeader::find($administrative_leader);


        if($administrative_leader->update($request->all()))
        {
            return redirect('workflows/administrative-leaders')->with('success','Administrative Leader saved!');
        }
    }

    public function delete(Request $request)
    {
        if(ApprovalLevelLeader::destroy($request->administrative_leader))
        {
            return back()->with('success','Administrative Leader deleted!');
        }
    }



}
