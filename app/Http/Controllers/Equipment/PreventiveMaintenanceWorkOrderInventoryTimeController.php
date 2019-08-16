<?php

namespace App\Http\Controllers\Equipment;

use App\Equipment\PreventiveMaintenanceWorkOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\PreventiveMaintenanceWorkOrderInventoryTime;
use App\Equipment\PreventiveMaintenanceWorkOrderInventory;

class PreventiveMaintenanceWorkOrderInventoryTimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }



    public function index()
    { }

    public function store(Request $request, $work_order_id, $work_order_inventory_id)
    {
        $work_order_inventory = PreventiveMaintenanceWorkOrderInventory::find($work_order_inventory_id);

        $preventive_maintenance_work_order = PreventiveMaintenanceWorkOrder::find($work_order_id);

        if ($shift_time = $work_order_inventory->PreventiveMaintenanceWorkOrderInventoryTimes()->create($request->all())) {
            if ($this->is_ilsm($shift_time)) {
                $preventive_maintenance_work_order->ilsmAssessment()->update(['ilsm_assessment_status_id' => 1]);
            }

            return response()->json(['status' => 'success']);
        }
    }

    public function delete(Request $request)
    {
        if (PreventiveMaintenanceWorkOrderInventoryTime::destroy($request->inventory_time_id)) {
            return response()->json(['status' => 'success']);
        }
    }

    private function is_ilsm(PreventiveMaintenanceWorkOrderInventoryTime $shift_time)
    {
        if (count($shift_time->PreventiveMaintenanceWorkOrderInventory->workOrder->equipment->assetCategory->eops) > 0) {
            foreach ($shift_time->PreventiveMaintenanceWorkOrderInventory->workOrder->equipment->assetCategory->eops as $eop) {

                //check for ilsm first
                if ($eop->is_ilsm) {
                    //if ilsm , lets check for shift first
                    if ($eop->is_ilsm_shift) {
                        //lets get matching shift for the demand order
                        $corresponding_shift  = $shift_time->PreventiveMaintenanceWorkOrderInventory->workOrder->getMaintenanceShift();

                        if ($corresponding_shift !== false) {
                            $corresponding_shift_time = \Carbon\Carbon::parse($shift_time->PreventiveMaintenanceWorkOrderInventory->workOrder->created_at->format('Y-m-d') . ' ' . $corresponding_shift->end_time);

                            if ($corresponding_shift_time->lessThan($shift_time->end_time)) {
                                return true;
                            }
                        }
                    } elseif (empty($eop->ilsm_hours_threshold) && !$eop->is_ilsm_shift) {
                        return true;
                    } elseif (!empty($eop->ilsm_hours_threshold)) {
                        $allowed_date = $shift_time->PreventiveMaintenanceWorkOrderInventory->workOrder->created_at->addHours($eop->ilsm_hours_threshold);

                        if ($allowed_date->lessThan($shift_time->end_time)) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
