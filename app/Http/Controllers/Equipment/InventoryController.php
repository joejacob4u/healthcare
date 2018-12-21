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
use App\Equipment\Inventory;
use App\Regulatory\Room;

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

    public function store(Request $request, $equipment_id, $baseline_date_id)
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

    public function edit($equipment_id, $baseline_date_id, $inventory_id)
    {
        $inventory = Inventory::find($inventory_id);
        $baseline_date = BaselineDate::find($baseline_date_id);
        $redundancies = Redundancy::pluck('name', 'id')->prepend('Please select a redundancy', 0);
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id')->prepend('Please select a department', 0);
        $rooms = BuildingDepartment::find($inventory->department_id)->rooms->pluck('room_number', 'id');
        $mission_criticalities = MissionCriticality::pluck('name', 'id')->prepend('Please select a criticality', 0);
        $incident_histories = IncidentHistory::pluck('name', 'id')->prepend('Please select a incident history', 0);
        return view('equipment.inventory.edit', ['redundancies' => $redundancies,'departments' => $departments,'mission_criticalities' => $mission_criticalities,'incident_histories' => $incident_histories,'baseline_date' => $baseline_date,'inventory' => $inventory,'rooms' => $rooms]);
    }

    public function save(Request $request, $equipment_id, $baseline_date_id, $inventory_id)
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
        
        $inventory = Inventory::find($inventory_id);
        
        if ($inventory->update($request->all())) {
            return redirect('equipment/'.$inventory->baselineDate->equipment->id.'/baseline-date/'.$baseline_date_id.'/inventory')->with('success', 'Inventory updated.');
        }
    }

    public function delete(Request $request)
    {
        if (Inventory::destroy($request->inventory_id)) {
            return response()->json(['status' => 'success']);
        }
    }
}
