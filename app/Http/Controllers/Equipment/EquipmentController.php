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
use App\Equipment\WorkOrder;
use Carbon\Carbon;
use App\Equipment\Inventory;

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

    public function equipmentView()
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();
        return view('equipment.equipment.equipment-view')->with('equipments', $equipments);
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
            'manufacturer' => 'required',
            'model_number' => 'required',
            'is_warranty_available' => 'required',
            'utilization' => 'required|numeric|min:1|max:100',
            'frequency' => 'required|not_in:0',
            'meet_current_oem_specifications' => 'required',
            'is_manufacturer_supported' => 'required',
            'impact_of_device_failure' => 'required',
            'is_manufacturer_supported' => 'required'
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
            'manufacturer' => 'required',
            'model_number' => 'required',
            'is_warranty_available' => 'required',
            'manufacturer_date' => 'required',
            'utilization' => 'required|numeric|min:1|max:100',
            'frequency' => 'required|not_in:0',
            'meet_current_oem_specifications' => 'required',
            'is_manufacturer_supported' => 'required',
            'impact_of_device_failure' => 'required',
            'is_manufacturer_supported' => 'required'
        ]);

        $equipment = Equipment::find($request->equipment_id);

        $current_baseline_date = $equipment->baseline_date;

        if ($equipment->update($request->except(['hco_id','site_id','equipment_id']))) {
            if ($current_baseline_date != $request->baseline_date) {

                //delete existing work order dates

                Equipment::where('building_id', session('building_id'))->where('equipment_id', $equipment->id)->delete();

                $work_order_dates = $equipment->calculateEquipmentWorkOrderDates();

                if (isset($work_order_dates)) {
                    foreach ($work_order_dates as $work_order_date) {
    
                        //save each work order one by one
                        
                        $equipment->workOrders()->save(new WorkOrder([
                            'name' => 'Work Order for '.$equipment->name.' for '.Carbon::parse($work_order_date)->toFormattedDateString(),
                            'work_order_date' => $work_order_date,
                            'building_id' => session('building_id'),
                            'equipment_id' => $equipment->id,
                            'status' => 'pending_initialization'
                        ]));
                    }
                }
            }
            
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
            foreach ($equipment->inventories as $inventory) {
                $csv->insertOne([
                $inventory->equipment->name,
                session('building_name'),
                $inventory->equipment->assetCategory->category->name,
                $inventory->equipment->assetCategory->name,
                $inventory->equipment->description,
                $inventory->equipment->manufacturer,
                $inventory->equipment->model_number,
                $inventory->equipment->serial_number,
                $inventory->equipment->identification_number,
                $inventory->equipment->preventive_maintenance_procedure,
                $inventory->redundancy->name,
                $inventory->missionCriticality->name,
                $inventory->incidentHistory->name,
                $inventory->equipment->manufacturer_date,
                $inventory->equipment->utilization,
                $inventory->equipment->estimated_replacement_cost,
                $inventory->equipment->estimated_deferred_maintenance_cost,
                $inventory->equipment->baseline_date,
                $inventory->equipment->maintenanceRequirement->name,
                $inventory->room->buildingDepartment->name,
                $inventory->room->room_number,
                $inventory->USLScore(),
                $inventory->FCINumber(),
                $inventory->missionCriticalityRatingScore(),
                $inventory->EMNumberScore(),
                $inventory->EMRatingScore(),
                $inventory->AdjustedEMRScore()
            ]);
            }
        }

        $csv->output('equipment_inventories_for_'.session('building_name').'_'.date('Y-m-d:H:i:s').'.csv');
        exit;
    }
}
