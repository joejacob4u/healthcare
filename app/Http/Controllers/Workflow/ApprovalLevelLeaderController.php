<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Workflow\ApprovalLevelLeader;

class ApprovalLevelLeaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $approval_level_leaders = ApprovalLevelLeader::get();
        return view('workflow.approval-level-leader.index',['approval_level_leaders' => $approval_level_leaders]);
    }

    public function create()
    {
        return view('workflow.approval-level-leader.add');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'signing_level_amount' => 'required'
        ]);

        if(ApprovalLevelLeader::create($request->all()))
        {
            return redirect('workflows/approval-level-leaders')->with('success','New Approval Level Leader added!');
        }
    }

    public function edit($approval_level_leader)
    {
        $approval_level_leader = ApprovalLevelLeader::find($approval_level_leader);
        return view('workflow.approval-level-leader.edit',['approval_level_leader' => $approval_level_leader]);
    }

    public function save(Request $request,$approval_level_leader)
    {
        $this->validate($request,[
            'title' => 'required',
            'signing_level_amount' => 'required'
        ]);

        $approval_level_leader = ApprovalLevelLeader::find($approval_level_leader);

        if($approval_level_leader->update($request->all()))
        {
            return redirect('workflows/approval-level-leaders')->with('success','Approval Level Leader saved!');
        }
    }

    public function delete(Request $request)
    {
        if(ApprovalLevelLeader::destroy($request->approval_level_leader_id))
        {
            return back()->with('success','Deleted!');
        }
    }


}
