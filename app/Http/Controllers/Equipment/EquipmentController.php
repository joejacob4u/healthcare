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
        $this->middleware('user')->only('equipmentView');
    }

    public function index()
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();
        return view('equipment.equipment.index')->with('equipments', $equipments);
    }

    public function equipmentView($filter)
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();
        return view('equipment.equipment.'.$filter.'-view')->with('equipments', $equipments);
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
            'utilization' => 'required|numeric|min:1|max:100',
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
            'utilization' => 'required|numeric|min:1|max:100',
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
            'Equipment Name',
            'Building',
            'Equipment Category',
            'Equipment Asset Category',
            'Equipment Description',
            'Manufacturer',
            'Model Number',
            'Serial Number',
            'Equipment Inventory Identification',
            'Preventive Maintenance Procedure',
            'Redundancy',
            'Mission Criticality',
            'Incident History',
            'Installation Date',
            'Annual Utilization %',
            'Estimated Replacement Cost',
            'Estimated Deferred Maintenance Cost per Year',
            'Baseline date:',
            'Maintenance Requirement Frequency',
            'Department',
            'Room',
            'USL Score',
            'FCI #',
            'MIssion Criticality Score',
            'EM Number Score',
            'EM Rating Score',
            'Adjusted EM Rating Score'
        ]);

        foreach ($equipments as $equipment) {
            $csv->insertOne([
                $equipment->name,
                session('building_name'),
                $equipment->assetCategory->category->name,
                $equipment->assetCategory->name,
                $equipment->description,
                $equipment->manufacturer,
                $equipment->model_number,
                $equipment->serial_number,
                $equipment->identification_number,
                $equipment->preventive_maintenance_procedure,
                $equipment->redundancy->name,
                $equipment->missionCriticality->name,
                $equipment->incidentHistory->name,
                $equipment->manufacturer_date,
                $equipment->utilization,
                $equipment->estimated_replacement_cost,
                $equipment->estimated_deferred_maintenance_cost,
                $equipment->baseline_date,
                $equipment->maintenanceRequirement->name,
                $equipment->room->buildingDepartment->name,
                $equipment->room->room_number,
                $equipment->USLScore(),
                $equipment->FCINumber(),
                $equipment->missionCriticalityRatingScore(),
                $equipment->EMNumberScore(),
                $equipment->EMRatingScore(),
                $equipment->AdjustedEMRScore()
            ]);
        }

        $csv->output('equipments_for_'.session('building_name').'_'.date('Y-m-d:H:i:s').'.csv');
        exit;
    }
}
