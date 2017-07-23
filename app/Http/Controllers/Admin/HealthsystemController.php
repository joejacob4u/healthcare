<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\HealthSystem;

class HealthsystemController extends Controller
{
    public function index()
    {
      $healthsystems = HealthSystem::get();

      return view('admin.healthsystem.index',[
          'healthsystems' => $healthsystems,
          'page_description' => 'Manage your healthsystems here',
          'page_title' => 'HealthCare System'
      ]);
    }

    public function add()
    {
      return view('admin.healthsystem.add');
    }

    public function create(Request $request)
    {
      $this->validate($request,[
        'healthcare_system' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required|unique:healthsystem',
        'admin_phone' => 'required|unique:healthsystem',
        'state' => 'required'
      ]);

      if(HealthSystem::create($request->all()))
      {
        return redirect('admin/healthsystem')->with('success','New Health System added!');
      }
    }

    public function edit($id)
    {
      $healthsystem = HealthSystem::find($id);
      return view('admin.healthsystem.edit',['healthsystem' => $healthsystem]);
    }

    public function save(Request $request,$id)
    {
      $this->validate($request,[
        'healthcare_system' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required',
        'admin_phone' => 'required',
        'state' => 'required'
      ]);

      $healthsystem = HealthSystem::find($id);

      if($healthsystem->update($request->all()))
      {
        return back()->with('success','Health System updated!');
      }

    }

    public function delete(Request $request)
    {
       if(HealthSystem::destroy($request->id))
       {
         return 'true';
       }
    }
}
