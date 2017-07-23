<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\HCO;
use App\Admin\HealthSystem;

class HCOController extends Controller
{
    public function index()
    {
      $hcos = HCO::get();
      return view('admin.hco.index',['hcos' => $hcos]);
    }

    public function add()
    {
      $healthcare_systems = HealthSystem::pluck('healthcare_system','id');
      return view('admin.hco.add',['healthcare_systems' => $healthcare_systems]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
          'healthsystem_id' => 'required',
          'facility_name' => 'required',
          'address' => 'required',
          'hco_id' => 'required|unique:hco'
        ]);

        $healthsystem = HealthSystem::find($request->healthsystem_id);

        if($healthsystem->HCOs()->create($request->all()))
        {
            return redirect('admin/hco')->with('success','HCO created successfully.');
        }
    }

    public function edit($id)
    {
        $hco = HCO::find($id);
        $healthcare_systems = HealthSystem::pluck('healthcare_system','id');
        return view('admin.hco.edit',['healthcare_systems' => $healthcare_systems, 'hco' => $hco]);
    }

    public function save(Request $request,$id)
    {
        $this->validate($request,[
          'healthsystem_id' => 'required',
          'facility_name' => 'required',
          'address' => 'required',
          'hco_id' => 'required'
        ]);

        $hco = HCO::find($id);

        if($hco->update($request->all()))
        {
          return redirect('admin/hco')->with('success','HCO updated successfully.');
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
