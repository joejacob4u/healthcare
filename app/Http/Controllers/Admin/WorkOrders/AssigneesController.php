<?php

namespace App\Http\Controllers\Admin\WorkOrders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WorkOrder\Assignee;

class AssigneesController extends Controller
{
    public function index()
    {
      $assignees = Assignee::get();
      return view('admin.work-orders.assignees.index',['assignees' => $assignees]);
    }

    public function create()
    {
      return view('admin.work-orders.assignees.add');
    }

    public function store(Request $request)
    {
      $this->validate($request,[
        'name' => 'required',
        'email' => 'required'
      ]);

      if(Assignee::create($request->all()))
      {
        return redirect('admin/work/assignee')->with('success','New assignee created!');
      }
    }

    public function edit($id)
    {
      $assignee = Assignee::find($id);
      return view('admin.work-orders.assignees.edit',['assignee' => $assignee]);
    }
}
