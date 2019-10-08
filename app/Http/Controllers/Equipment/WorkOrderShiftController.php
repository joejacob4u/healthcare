<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\PreventiveMaintenanceWorkOrder;
use App\Equipment\PreventiveMaintenanceWorkOrderInventory;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;
use App\Equipment\Inventory;

class WorkOrderShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function add(Request $request, $work_order_id)
    {
        $work_order = PreventiveMaintenanceWorkOrder::find($work_order_id);

        if ($work_order_shift = $work_order->shifts()->create($request->except(['work_order_inventory_id']))) {
            $this->update_inventory_work_orders($work_order_id, $request->work_order_inventory_id, $work_order_shift->start_time, $work_order_shift->end_time);
            return response()->json(['status' => 'success']);
        }
    }

    private function update_inventory_work_orders($work_order_id, $work_order_inventories, $start_time, $end_time)
    {
        $work_order_inventories = PreventiveMaintenanceWorkOrderInventory::whereIn('id', $work_order_inventories)->get();

        //only for inventories that are compliant and have not yet have start/end time set


        if (count($work_order_inventories) > 0) {
            $times = [];
            $startTime = new DateTime($start_time);
            $endTime = new DateTime($end_time);

            $diff = $startTime->diff($endTime);

            //calcualte interval in mins based on inventory count

            $interval = intval((($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i) / count($work_order_inventories));

            while ($startTime < $endTime) {
                $times[] = ['start_time' => $startTime->format('Y-m-d H:i:s'), 'end_time' => $startTime->modify('+' . $interval . ' minutes')->format('Y-m-d H:i:s'), 'user_id' => Auth::user()->id, 'equipment_work_order_status_id' => 2];
            }

            foreach ($work_order_inventories as $key => $work_order_inventory) {
                $work_order_inventory->PreventiveMaintenanceWorkOrderInventoryTimes()->create($times[$key]);
            }
        }
    }

    public function inventories($work_order_id)
    {
        $inventories = PreventiveMaintenanceWorkOrderInventory::with('inventory')->where('equipment_work_order_id', $work_order_id)->with('PreventiveMaintenanceWorkOrderInventoryTimes')->get();

        return response()->json(['status' => 'success', 'inventories' => $inventories]);
    }
}
