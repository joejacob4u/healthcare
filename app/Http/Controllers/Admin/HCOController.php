<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;
use App\Regulatory\HealthSystem;
use App\Regulatory\Accreditation;

class HCOController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index($healthsystem_id)
    {
        $health_system = HealthSystem::find($healthsystem_id);
        $hcos = $health_system->HCOs;
        return view('admin.healthsystem.hco.index', ['hcos' => $hcos,'health_system' => $health_system]);
    }

    public function add($healthsystem_id)
    {
        $accreditations = Accreditation::pluck('name', 'id');
        return view('admin.healthsystem.hco.add', ['healthsystem' => HealthSystem::find($healthsystem_id),'accreditations' => $accreditations]);
    }

    public function create(Request $request, $healthsystem_id)
    {
        $this->validate($request, [
          'facility_name' => 'required',
          'address' => 'required',
          'hco_id' => 'required|unique:hco',
          'accreditations' => 'not_in:0'
        ]);

        foreach ($request->accreditations as $accreditation) {
            $aAccreditations[] = Accreditation::find($accreditation);
        }


        $path = '';

        if ($request->hasFile('hco_logo')) {
            $path = $request->file('hco_logo')->store('logo/hco', 's3');
        }
        
        $request->request->add(['hco_logo' => $path]);

        $healthsystem = HealthSystem::find($healthsystem_id);

        if ($hco = $healthsystem->HCOs()->create($request->all())) {
            if ($hco->accreditations()->saveMany($aAccreditations)) {
                return redirect('admin/healthsystem/'.$healthsystem_id.'/hco')->with('success', 'HCO created successfully.');
            }
        }
    }

    public function edit($healthsystem_id, $id)
    {
        $hco = HCO::find($id);
        $accreditations = Accreditation::pluck('name', 'id');
        return view('admin.healthsystem.hco.edit', ['healthsystem' => HealthSystem::find($healthsystem_id), 'hco' => $hco, 'accreditations' => $accreditations]);
    }

    public function save(Request $request, $healthsystem_id, $id)
    {
        $this->validate($request, [
          'facility_name' => 'required',
          'address' => 'required',
          'hco_id' => 'required',
          'accreditations' => 'not_in:0'
        ]);

        foreach ($request->accreditations as $accreditation) {
            $aAccreditations[] = Accreditation::find($accreditation)->id;
        }


        $healthsystem = HealthSystem::find($healthsystem_id);

        $path = '';
        
        if ($request->hasFile('hco_logo')) {
            $path = $request->file('hco_logo')->store('logo/hco', 's3');
        }
        
        $request->request->add(['hco_logo' => $path]);

        if ($healthsystem->HCOs()->where('id', $id)->update(request()->except(['_token','accreditations']))) {
            if (HCO::find($id)->accreditations()->sync($aAccreditations)) {
                return redirect('admin/healthsystem/'.$healthsystem_id.'/hco')->with('success', 'HCO updated successfully.');
            }
        }
    }

    public function delete(Request $request)
    {
        if (HCO::destroy($request->id)) {
            return 'true';
        }
    }
}
