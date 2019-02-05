<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\DemandWorkOrder;
use App\Equipment\DemandWorkOrderShift;

class DemandWorkOrderShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function store(Request $request, $demand_work_order_id)
    {
        $demand_work_order = DemandWorkOrder::find($demand_work_order_id);

        if ($demand_work_order->shifts()->create($request->all())) {
            return response()->json(['status' => 'success']);
        }
    }

    public function delete(Request $request)
    {
        if (DemandWorkOrderShift::destroy($request->shift_id)) {
            return response()->json(['status' => 'success']);
        }
    }
}
