<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\WorkOrder;
use App\Equipment\WorkOrderInventory;
use DateTime;
use DateInterval;
use DatePeriod;

class WorkOrderShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function add(Request $request, $work_order_id)
    {
        $work_order = WorkOrder::find($work_order_id);

        if ($work_order_shift = $work_order->shifts()->create($request->all())) {
            $this->update_inventory_work_orders($work_order_id, $work_order_shift->start_time, $work_order_shift->end_time);
            return response()->json(['status' => 'success']);
        }
    }

    private function update_inventory_work_orders($work_order_id, $start_time, $end_time)
    {
        $work_order_inventories = WorkOrderInventory::where('equipment_work_order_id', $work_order_id)->where('equipment_work_order_status_id', 1)->where('start_time', '')->where('end_time', '')->get();
        
        //only for inventories that are compliant and have not yet have start/end time set


        if (count($work_order_inventories) > 0) {
            $times = [];
            $startTime = new DateTime($start_time);
            $endTime = new DateTime($end_time);

            $diff = $startTime->diff($endTime);

            //calcualte interval in mins based on inventory count

            $interval = intval((($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i) / count($work_order_inventories));

            while ($startTime < $endTime) {
                $times[] = ['start_time' => $startTime->format('Y-m-d H:i:s'),'end_time' => $startTime->modify('+'.$interval.' minutes')->format('Y-m-d H:i:s')];
            }



            foreach ($work_order_inventories as $key => $work_order_inventory) {
                $work_order_inventory->update($times[$key]);
            }
        }
    }
}
