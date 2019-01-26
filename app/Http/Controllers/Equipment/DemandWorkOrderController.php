<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;
use App\Equipment\Trade;
use App\Equipment\PreventiveMaintenanceWorkOrderPriority;
use App\Equipment\DemandWorkOrder;

class DemandWorkOrderController extends Controller
{
    public function index()
    {
    }

    public function form($healthsystem_id)
    {
        $hcos = HCO::where('healthsystem_id', $healthsystem_id)->pluck('facility_name', 'id')->prepend('Please select a hco', '0');
        $trades = Trade::pluck('name', 'id');
        $work_order_priorities = WorkOrderPriority::pluck('name', 'id');
        return view('demand-work-order-form', ['hcos' => $hcos,'trades' => $trades,'healthsystem_id' => $healthsystem_id,'work_order_priorities' => $work_order_priorities]);
    }

    public function store(Request $request)
    {
        if (DemandWorkOrder::create($request->all())) {
            return back()->with('success', 'Demand work order created!');
        }
    }
}
