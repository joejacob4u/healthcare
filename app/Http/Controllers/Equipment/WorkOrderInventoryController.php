<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\WorkOrder;
use App\Equipment\WorkOrderStatus;
use App\Equipment\WorkOrderInventory;
use Auth;
use App\Equipment\WorkOrderInventoryTime;

class WorkOrderInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($work_order_id)
    {
        $work_order = WorkOrder::find($work_order_id);
        $work_order_statuses = WorkOrderStatus::pluck('name', 'id');
        return view('equipment.preventive-maintenance.inventory', ['work_order' => $work_order, 'work_order_statuses' => $work_order_statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $work_order_id)
    {
        $work_order_inventory = WorkOrderInventory::find($request->inventory_id);

        if ($work_order_inventory->update([$request->field => $request->value,'user_id' => Auth::user()->id])) {
            return response()->json(['status' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fetchTimes(Request $request, $work_order_id)
    {
        $work_order_inventory_times = WorkOrderInventoryTime::with('user')->with('workOrderStatus')->where('equipment_work_order_inventory_id', $request->work_order_inventory_id)->latest()->get();
        return response()->json(['status' => 'success','work_order_inventory_times' => $work_order_inventory_times]);
    }
}
