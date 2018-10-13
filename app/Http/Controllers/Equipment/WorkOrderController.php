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
        $this->validate($request, [
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'not_in:0',
            'comment' => 'required_if:status,==,3|required_if:status,==,2',
            'is_in_house' => 'not_in:-1'
        ]);

        if ($request->is_in_house == 0) {
            $no_of_files = count(Storage::disk('s3')->files($request->attachment));

            if ($no_of_files < 1) {
                return back()->with('warning', 'You must upload file(s)');
            }
        }

        $work_order = WorkOrder::find($request->equipment_work_order_id);

        $work_order->update(['is_in_house' => $request->is_in_house]);

        $status = WorkOrderStatus::find($request->status);
            
        $work_order->workOrderStatuses()->save($status, ['comment' => $request->comment,'attachment' => $request->attachment,'start_time' => $request->start_time,'end_time' => $request->end_time,'user_id' =>$request->user_id]);
            
        return redirect('equipment/pm/work-orders/update/'.$request->equipment_work_order_id)->with('success', 'Work Order Updated!');
    }
}
