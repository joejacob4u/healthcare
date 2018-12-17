<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Equipment;
use App\Regulatory\BuildingDepartment;
use App\Equipment\BaselineDate;
use App\Equipment\MaintenanceRequirement;
use App\Biomed\MissionCriticality;
use App\Equipment\IncidentHistory;
use App\Equipment\Redundancy;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($equipment_id, $baseline_date_id)
    {
        $baseline_date = BaselineDate::find($baseline_date_id);
        return view('equipment.inventory.index', ['baseline_date' => $baseline_date]);
    }

    public function create($equipment_id, $baseline_date_id)
    {
        $baseline_date = BaselineDate::find($baseline_date_id);
        $redundancies = Redundancy::pluck('name', 'id')->prepend('Please select a redundancy', 0);
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id')->prepend('Please select a department', 0);
        $mission_criticalities = MissionCriticality::pluck('name', 'id')->prepend('Please select a criticality', 0);
        $incident_histories = IncidentHistory::pluck('name', 'id')->prepend('Please select a incident history', 0);
        return view('equipment.inventory.add', ['redundancies' => $redundancies,'departments' => $departments,'mission_criticalities' => $mission_criticalities,'incident_histories' => $incident_histories,'baseline_date' => $baseline_date]);
    }

    public function store(Request $request, $baseline_date_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'serial_number' => 'required',
            'identification_number' => 'required',
            'maintenance_redundancy_id' => 'required',
            'biomed_mission_criticality_id' => 'required',
            'equipment_incident_history_id' => 'required',
            'estimated_deferred_maintenance_cost' => 'required',
            'estimated_replacement_cost' => 'required'
        ]);
        
        $baseline_date = BaselineDate::find($baseline_date_id);
        
        if ($baseline_date->inventories()->create($request->all())) {
            return redirect('equipment/'.$baseline_date->equipment->id.'/baseline-date/'.$baseline_date->id.'/inventory')->with('success', 'New inventory created.');
        }
    }
}
