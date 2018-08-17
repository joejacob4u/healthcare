<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\MaintenanceRequirement;

class MaintenanceRequirementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }
    
    public function index()
    {
        $maintenance_requirements = MaintenanceRequirement::get();
        return view('equipment.maintenance-requirement', ['maintenance_requirements' => $maintenance_requirements]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:equipment_maintenance_requirements,name',
            'score' => 'required|numeric'
        ]);

        if (MaintenanceRequirement::create($request->all())) {
            return back()->with('success', 'Maintenance Requirement created!');
        }
    }

    public function delete(Request $request)
    {
        MaintenanceRequirement::destroy($request->id);
        return 'true';
    }
}
