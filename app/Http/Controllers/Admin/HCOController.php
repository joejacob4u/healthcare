<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\HCO;
use App\Admin\HealthSystem;

class HCOController extends Controller
{
    public function index($healthsystem_id)
    {
      $health_system = HealthSystem::find($healthsystem_id);
      $hcos = $health_system->HCOs;
      return view('admin.healthsystem.hco.index',['hcos' => $hcos,'health_system' => $health_system]);
    }

    public function add($healthsystem_id)
    {
      return view('admin.healthsystem.hco.add',['healthsystem' => HealthSystem::find($healthsystem_id)]);
    }

    public function create(Request $request,$healthsystem_id)
    {
        $this->validate($request,[
          'facility_name' => 'required',
          'address' => 'required',
          'hco_id' => 'required|unique:hco'
        ]);

        $healthsystem = HealthSystem::find($healthsystem_id);

        if($healthsystem->HCOs()->create($request->all()))
        {
            return redirect('admin/healthsystem/'.$healthsystem_id.'/hco')->with('success','HCO created successfully.');
        }
    }

    public function edit($healthsystem_id,$id)
    {
        $hco = HCO::find($id);
        return view('admin.healthsystem.hco.edit',['healthsystem' => HealthSystem::find($healthsystem_id), 'hco' => $hco]);
    }

    public function save(Request $request,$healthsystem_id,$id)
    {
        $this->validate($request,[
          'facility_name' => 'required',
          'address' => 'required',
          'hco_id' => 'required'
        ]);

        $healthsystem = HealthSystem::find($healthsystem_id);

        if($healthsystem->HCOs()->update(request()->except(['_token'])))
        {
          return redirect('admin/healthsystem/'.$healthsystem_id.'/hco')->with('success','HCO updated successfully.');
        }

    }

    public function delete(Request $request)
    {
       if(HCO::destroy($request->id))
       {
         return 'true';
       }
    }



}
