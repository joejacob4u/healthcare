<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Category;
use App\Equipment\Redundancy;
use App\Regulatory\HCO;
use Auth;
use App\Regulatory\BuildingDepartment;
use App\Equipment\Equipment;
use App\Equipment\MaintenanceRequirement;
use App\Biomed\MissionCriticality;
use App\Equipment\IncidentHistory;

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
        $maintenance_requirements = MaintenanceRequirement::pluck('name', 'id')->prepend('Please select a maintenance requirement', 0);
        $redundancies = Redundancy::pluck('name', 'id')->prepend('Please select a redundancy', 0);
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id')->prepend('Please select a department', 0);
        $mission_criticalities = MissionCriticality::pluck('name', 'id')->prepend('Please select a criticality', 0);
        $incident_histories = IncidentHistory::pluck('name', 'id')->prepend('Please select a incident history', 0);
        return view('equipment.equipment.add', ['hcos' => $hcos,'categories' => $categories,'maintenance_requirements' => $maintenance_requirements,'redundancies' => $redundancies,'departments' => $departments,'mission_criticalities' => $mission_criticalities,'incident_histories' => $incident_histories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'building_id' => 'required',
            'name' => 'required|unique:equipments,name',
            'equipment_category_id' => 'required|not_in:0',
            'equipment_asset_category_id' => 'required|not_in:0',
            'equipment_maintenance_requirement_id' => 'required|not_in:0',
            'maintenance_redundancy_id' => 'required|not_in:0',
            'manufacturer' => 'required',
            'model_number' => 'required',
            'serial_number' => 'required|unique:equipments,serial_number',
            'manufacturer_date' => 'required',
            'estimated_replacement_cost' => 'required',
            'estimated_deferred_maintenance_cost' => 'required',
            'identification_number' => 'required',
            'department_id' => 'required',
            'room_id' => 'required',
            'biomed_mission_criticality_id' => 'not_in:0',
            'equipment_incident_history_id' => 'not_in:0',
            'baseline_date' => 'required'
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
        $maintenance_requirements = MaintenanceRequirement::pluck('name', 'id')->prepend('Please select a maintenance requirement', 0);
        $redundancies = Redundancy::pluck('name', 'id')->prepend('Please select a redundancy', 0);
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id')->prepend('Please select a department', 0);
        $mission_criticalities = MissionCriticality::pluck('name', 'id')->prepend('Please select a criticality', 0);
        $incident_histories = IncidentHistory::pluck('name', 'id')->prepend('Please select a incident history', 0);
        return view('equipment.equipment.edit', ['equipment' => $equipment,'hcos' => $hcos,'categories' => $categories,'maintenance_requirements' => $maintenance_requirements,'redundancies' => $redundancies,'departments' => $departments,'mission_criticalities' => $mission_criticalities,'incident_histories' => $incident_histories]);
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'building_id' => 'required',
            'name' => 'required',
            'equipment_category_id' => 'required',
            'equipment_asset_category_id' => 'required',
            'equipment_maintenance_requirement_id' => 'required',
            'maintenance_redundancy_id' => 'required',
            'manufacturer' => 'required',
            'model_number' => 'required',
            'serial_number' => 'required',
            'manufacturer_date' => 'required',
            'estimated_replacement_cost' => 'required',
            'estimated_deferred_maintenance_cost' => 'required',
            'identification_number' => 'required',
            'department_id' => 'required',
            'room_id' => 'required',
            'biomed_mission_criticality_id' => 'not_in:0',
            'equipment_incident_history_id' => 'not_in:0',
            'baseline_date' => 'required'

        ]);

        $equipment = Equipment::find($request->equipment_id);

        if ($equipment->update($request->except(['hco_id','site_id','equipment_id']))) {
            return redirect('/equipment')->with('success', 'Equipment has been saved.');
        }
    }

    public function download()
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();
        
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne([
            'Name',
            'Category',
            'Category Asset',
            'Description',
            'Maintenance Requirement',
            'Redundancy',
            'Mission Criticality',
            'Incident History',
            'Preventive Maintenance Procedure',
            'Room',
            'Standard Label',
            'Standard Label Text',
            'EOP Name',
            'EOP Text',
            'Finding',
            'Potential to cause harm',
            'Policy Issue',
            'Finding created at:',
            'Measure of Success',
            'Benefit',
            'Plan of Action',
            'Last Assigned To',
            'Due Date',
            'Status'
        ]);

        foreach (json_decode(json_encode($findings), true) as $finding) {
            $csv->insertOne($finding);
        }

        $csv->output('action_sheet_healthsystem_'.date('Y-m-d:H:i:s').'.csv');
        exit;
    }
}
