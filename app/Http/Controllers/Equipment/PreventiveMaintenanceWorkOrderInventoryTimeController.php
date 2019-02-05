<?php

namespace App\Http\Controllers\Equipment;

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
    {
    }

    public function store(Request $request, $work_order_id, $work_order_inventory_id)
    {
        $work_order_inventory = PreventiveMaintenanceWorkOrderInventory::find($work_order_inventory_id);

        if ($work_order_inventory->PreventiveMaintenanceWorkOrderInventoryTimes()->create($request->all())) {
            return response()->json(['status' => 'success']);
        }
    }

    public function delete(Request $request)
    {
        if (PreventiveMaintenanceWorkOrderInventoryTime::destroy($request->inventory_time_id)) {
            return response()->json(['status' => 'success']);
        }
    }
}
