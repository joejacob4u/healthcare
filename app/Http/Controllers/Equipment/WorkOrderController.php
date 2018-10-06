<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\WorkOrder;
use Storage;
use App\Equipment\WorkOrderStatus;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $work_orders = WorkOrder::where('building_id', session('building_id'))->get();
        return view('equipment.preventive-maintenance.index', ['work_orders' => $work_orders]);
    }

    public function update($work_order_id)
    {
        $work_order = WorkOrder::find($work_order_id);
        $work_order_statuses = WorkOrderStatus::whereNotIn('id', $work_order->workOrderStatuses->pluck('id')->toArray())->pluck('name', 'id');
        return view('equipment.preventive-maintenance.update', ['work_order' => $work_order,'work_order_statuses' => $work_order_statuses]);
    }

    public function fetch(Request $request)
    {
        return response()->json(['work_order' => WorkOrder::with('equipment')->with('equipment.room')->find($request->work_order_id)]);
    }

    public function save(Request $request, $work_order_id)
    {
        $this->validate($request, [
            'is_in_house' => 'required|not_in:-1',
            'start_time' => 'required',
            'end_time' => 'required_unless:status,ongoing',
            'status' => 'not_in:0',
            'parts_on_order' => 'required_if:status,==,open',
            'comment' => 'required_if:status,==,bcm'
        ]);

        if ($request->is_in_house == 0) {
            $no_of_files = count(Storage::disk('s3')->files($request->attachment));

            if ($no_of_files < 1) {
                return back()->with('warning', 'You must upload file(s)');
            }
        }

        $work_order = WorkOrder::find($work_order_id);

        if ($work_order->update($request->all())) {
            return redirect('equipment/pm/work-orders/update/'.$work_order_id)->with('success', 'Work Order Updated!');
        }
    }

    public function saveStatus(Request $request)
    {
        $work_order = WorkOrder::find($request->equipment_work_order_id);

        if ($work_order->update(['start_time' => $request->start_time,'end_time' => $request->end_time])) {
            $status = WorkOrderStatus::find($request->status);
            
            $work_order->workOrderStatuses()->save($status, ['comment' => $request->comment,'attachment' => $request->attachment]);
            
            return redirect('equipment/pm/work-orders/update/'.$request->equipment_work_order_id)->with('success', 'Work Order Updated!');
        }
    }
}
