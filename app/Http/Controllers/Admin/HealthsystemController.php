<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HealthSystem;

class HealthsystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }
    
    public function index()
    {
        $healthsystems = HealthSystem::get();

        return view('admin.healthsystem.index', [
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
        $this->validate($request, [
        'healthcare_system' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required|unique:healthsystem',
        'admin_phone' => 'required|unique:healthsystem',
        'state' => 'required'
      ]);

        $path = '';
      
        if ($request->hasFile('healthsystem_logo_image')) {
            $path = $request->file('healthsystem_logo_image')->store('logo/healthsystem', 's3');
        }
      
        $request->request->add(['healthsystem_logo' => $path]);
      

        if (HealthSystem::create($request->all())) {
            return redirect('healthsystem')->with('success', 'New Health System added!');
        }
    }

    public function edit($id)
    {
        $healthsystem = HealthSystem::find($id);
        return view('admin.healthsystem.edit', ['healthsystem' => $healthsystem]);
    }

    public function save(Request $request, $id)
    {
        $this->validate($request, [
        'healthcare_system' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required',
        'admin_phone' => 'required',
        'state' => 'required'
      ]);

        $healthsystem = HealthSystem::find($id);

        $path = '';
      
        if ($request->hasFile('healthsystem_logo_image')) {
            $path = $request->file('healthsystem_logo_image')->store('logo/healthsystem', 's3');
        }

        $request->request->add(['healthsystem_logo' => $path]);
      

        if ($healthsystem->update($request->all())) {
            return back()->with('success', 'Health System updated!');
        }
    }

    public function delete(Request $request)
    {
        if (HealthSystem::destroy($request->id)) {
            return 'true';
        }
    }
}
