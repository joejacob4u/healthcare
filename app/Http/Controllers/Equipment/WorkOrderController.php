<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\PreventiveMaintenanceWorkOrder;
use App\Equipment\Equipment;
use App\Equipment\DemandWorkOrder;


class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        if (isset($_REQUEST['equipment_id'])) {
            $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->where('equipment_id', $_REQUEST['equipment_id'])->whereBetween('work_order_date', [$_REQUEST['from'], $_REQUEST['to']])->orderBy('work_order_date','desc')->paginate(15);
        } else {
            $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->where('work_order_date','<',date('Y-m-d',strtotime('tomorrow')))->orderBy('work_order_date','desc')->paginate(15);
        } 
        
        $demand_work_orders = DemandWorkOrder::where('building_id', session('building_id'))->orderBy('created_at','desc')->paginate(15);
        
        $equipments = Equipment::whereHas('workOrders', function ($query) {
            $query->where('building_id', session('building_id'));
        })->pluck('name', 'id');

        return view('equipment.work-order.index', ['pm_work_orders' => $pm_work_orders,'demand_work_orders' => $demand_work_orders,'equipments' => $equipments]);

    }

}
