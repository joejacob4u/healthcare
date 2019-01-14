<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\WorkOrderInventoryTime;
use App\Equipment\WorkOrderInventory;

class WorkOrderInventoryTimeController extends Controller
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
        $work_order_inventory = WorkOrderInventory::find($work_order_inventory_id);

        if ($work_order_inventory->workOrderInventoryTimes()->create($request->all())) {
            return response()->json(['status' => 'success']);
        }
    }

    public function delete(Request $request)
    {
        if (WorkOrderInventoryTime::destroy($request->inventory_time_id)) {
            return response()->json(['status' => 'success']);
        }
    }
}
