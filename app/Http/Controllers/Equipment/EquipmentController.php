<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Category;
use App\Equipment\RequirementFrequency;
use App\Equipment\Redundancy;
use App\Regulatory\HCO;
use Auth;
use App\Regulatory\BuildingDepartment;
use App\Equipment\Equipment;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();
        return view('equipment.equipment.index')->with('equipments', $equipments);
    }

    public function create()
    {
        $hcos = HCO::where('healthsystem_id', Auth::user()->healthsystem_id)->pluck('facility_name', 'id')->prepend('Please select an hco', 0);
        $categories = Category::pluck('name', 'id')->prepend('Please select a category', 0);
        $requirement_frequencies = RequirementFrequency::pluck('name', 'id')->prepend('Please select a requirement frequency', 0);
        $redundancies = Redundancy::pluck('name', 'id')->prepend('Please select a redundancy', 0);
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id')->prepend('Please select a department', 0);
        return view('equipment.equipment.add', ['hcos' => $hcos,'categories' => $categories,'requirement_frequencies' => $requirement_frequencies,'redundancies' => $redundancies,'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'building_id' => 'required',
            'name' => 'required|unique:equipments,name',
            'equipment_category_id' => 'required',
            'equipment_asset_category_id' => 'required',
            'equipment_frequency_requirement_id' => 'required',
            'maintenance_redundancy_id' => 'required',
            'manufacturer' => 'required',
            'model_number' => 'required',
            'serial_number' => 'required|unique:equipments,serial_number',
            'manufacturer_date' => 'required',
            'estimated_replacement_cost' => 'required',
            'estimated_deferred_maintenance_cost' => 'required',
            'identification_number' => 'required',
            'department_id' => 'required',
            'room_id' => 'required'
        ]);

        if (Equipment::create($request->except(['hco_id','site_id']))) {
            return redirect('/equipment')->with('success', 'New equipment has been added.');
        }
    }

    public function edit($equipment_id)
    {
        $equipment = Equipment::find($equipment_id);
        $hcos = HCO::where('healthsystem_id', Auth::user()->healthsystem_id)->pluck('facility_name', 'id')->prepend('Please select an hco', 0);
        $categories = Category::pluck('name', 'id')->prepend('Please select a category', 0);
        $requirement_frequencies = RequirementFrequency::pluck('name', 'id')->prepend('Please select a requirement frequency', 0);
        $redundancies = Redundancy::pluck('name', 'id')->prepend('Please select a redundancy', 0);
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id')->prepend('Please select a department', 0);
        return view('equipment.equipment.edit', ['equipment' => $equipment,'hcos' => $hcos,'categories' => $categories,'requirement_frequencies' => $requirement_frequencies,'redundancies' => $redundancies,'departments' => $departments]);
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'building_id' => 'required',
            'name' => 'required',
            'equipment_category_id' => 'required',
            'equipment_asset_category_id' => 'required',
            'equipment_frequency_requirement_id' => 'required',
            'maintenance_redundancy_id' => 'required',
            'manufacturer' => 'required',
            'model_number' => 'required',
            'serial_number' => 'required',
            'manufacturer_date' => 'required',
            'estimated_replacement_cost' => 'required',
            'estimated_deferred_maintenance_cost' => 'required',
            'identification_number' => 'required',
            'department_id' => 'required',
            'room_id' => 'required'
        ]);

        $equipment = Equipment::find($request->equipment_id);

        if ($equipment->update($request->except(['hco_id','site_id','equipment_id']))) {
            return redirect('/equipment')->with('success', 'Equipment has been saved.');
        }
    }
}
