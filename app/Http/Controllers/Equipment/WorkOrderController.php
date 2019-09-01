<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\PreventiveMaintenanceWorkOrder;
use App\Equipment\Equipment;
use App\Equipment\DemandWorkOrder;
use App\Equipment\IlsmPreassessmentQuestion;
use App\Equipment\IlsmAssessment;
use App\SystemTier;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index($system_tier_id)
    {

        $system_tier = SystemTier::find($system_tier_id);
        $equipment_ids = [];

        foreach ($system_tier->assetCategories as $assetCategory) {
            foreach ($assetCategory->equipments as $equipment) {
                $equipment_ids[] = $equipment->id;
            }
        }

        if (isset($_REQUEST['equipment_id'])) {
            $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->where('equipment_id', $_REQUEST['equipment_id'])->whereBetween('work_order_date', [$_REQUEST['from'], $_REQUEST['to']])->orderBy('work_order_date', 'desc')->paginate(15);
        } else {
            $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->whereIn('equipment_id', $equipment_ids)->where('work_order_date', '<', date('Y-m-d', strtotime('tomorrow')))->orderBy('work_order_date', 'desc')->paginate(15);
        }

        $demand_work_orders = DemandWorkOrder::where('building_id', session('building_id'))->orderBy('created_at', 'desc')->paginate(15);

        $ilsm_preassessment_questions = IlsmPreassessmentQuestion::pluck('question', 'id');


        $ilsm_assessments = IlsmAssessment::where(function ($query) use ($demand_work_orders) {
            $query->whereIn('work_order_id', $demand_work_orders->pluck('id'))->where('work_order_type', 'App\Equipment\DemandWorkOrder');
        })->orWhere(function ($query) use ($pm_work_orders) {
            $query->whereIn('work_order_id', $pm_work_orders->pluck('id'))->where('work_order_type', 'App\Equipment\PreventiveMaintenanceWorkOrder');
        })->whereNotIn('ilsm_assessment_status_id', [2, 8])->paginate(50);

        $equipments = Equipment::whereHas('workOrders', function ($query) {
            $query->where('building_id', session('building_id'));
        })->pluck('name', 'id');

        return view('equipment.work-order.index', ['pm_work_orders' => $pm_work_orders, 'demand_work_orders' => $demand_work_orders, 'equipments' => $equipments, 'ilsm_preassessment_questions' => $ilsm_preassessment_questions, 'ilsm_assessments' => $ilsm_assessments]);
    }
}
