<?php

namespace App\Http\Controllers\Equipment;

use App\Equipment\BaselineDate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\PreventiveMaintenanceWorkOrder;
use App\Equipment\Equipment;
use App\Equipment\DemandWorkOrder;
use App\Equipment\IlsmPreassessmentQuestion;
use App\Equipment\IlsmAssessment;
use App\Equipment\WorkOrderStatus;
use App\Regulatory\Building;
use App\SystemTier;
use Illuminate\Support\Facades\Auth;

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

        //

        if (isset($_GET['work_order_identifier']) and $_GET['search'] == 'true' and empty($_GET['work_order_status'])) {

            //determine if its pm or dm

            if (isset($_GET['work_order_identifier']) and !empty($_GET['work_order_identifier'])) {
                //get work order id 

                $explode = explode("-", $_GET['work_order_identifier']);

                if (reset($explode) == 'PM') {
                    $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->where('id', end($explode))->paginate(15);
                    $demand_work_orders = DemandWorkOrder::where('building_id', session('building_id'))->whereIn('work_order_trade_id', $system_tier->trades->pluck('id'))->orderBy('created_at', 'desc')->paginate(15);
                } else {
                    $demand_work_orders = DemandWorkOrder::where('building_id', session('building_id'))->whereIn('work_order_trade_id', $system_tier->trades->pluck('id'))->orderBy('created_at', 'desc')->where('id', end($explode))->paginate(15);
                    if (isset($_REQUEST['equipment_id'])) {
                        $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->where('equipment_id', $_REQUEST['equipment_id'])->whereBetween('work_order_date', [$_REQUEST['from'], $_REQUEST['to']])->orderBy('work_order_date', 'desc')->paginate(15);
                    } else {
                        $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->whereIn('equipment_id', $equipment_ids)->where('work_order_date', '<', date('Y-m-d', strtotime('tomorrow')))->orderBy('work_order_date', 'desc')->paginate(15);
                    }
                }
            }

            if (isset($_GET['date_range']) and !empty($_GET['date_range']) and empty($_GET['work_order_identifier'])) {

                $explode = explode("-", $_GET['work_order_identifier']);
                $dates = explode("to", $_GET["date_range"]);

                $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->whereBetween('work_order_date', [reset($dates), end($dates)])->orderBy('work_order_date', 'desc')->paginate(15);
                $demand_work_orders = DemandWorkOrder::where('building_id', session('building_id'))->whereIn('work_order_trade_id', $system_tier->trades->pluck('id'))->whereBetween('created_at', [reset($dates), end($dates)])->orderBy('created_at', 'desc')->where('id', end($explode))->paginate(15);
            }
        } else {
            if (isset($_REQUEST['equipment_id'])) {
                $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->where('equipment_id', $_REQUEST['equipment_id'])->whereBetween('work_order_date', [$_REQUEST['from'], $_REQUEST['to']])->orderBy('work_order_date', 'desc')->paginate(15);
            } else {
                $pm_work_orders = PreventiveMaintenanceWorkOrder::where('building_id', session('building_id'))->whereIn('equipment_id', $equipment_ids)->where('work_order_date', '<', date('Y-m-d', strtotime('tomorrow')))->orderBy('work_order_date', 'desc')->paginate(15);
            }

            $demand_work_orders = DemandWorkOrder::where('building_id', session('building_id'))->whereIn('work_order_trade_id', $system_tier->trades->pluck('id'))->orderBy('created_at', 'desc')->paginate(15);
        }



        $ilsm_preassessment_questions = IlsmPreassessmentQuestion::pluck('question', 'id');


        $ilsm_assessments = IlsmAssessment::where(function ($query) use ($demand_work_orders) {
            $query->whereIn('work_order_id', $demand_work_orders->pluck('id'))->where('work_order_type', 'App\Equipment\DemandWorkOrder');
        })->orWhere(function ($query) use ($pm_work_orders) {
            $query->whereIn('work_order_id', $pm_work_orders->pluck('id'))->where('work_order_type', 'App\Equipment\PreventiveMaintenanceWorkOrder');
        })->whereNotIn('ilsm_assessment_status_id', [2, 8])->paginate(50);

        $equipments = Equipment::whereHas('workOrders', function ($query) {
            $query->where('building_id', session('building_id'));
        })->pluck('name', 'id');

        $work_order_statuses = WorkOrderStatus::pluck('name', 'name');

        //lets figure out if current user has pm work orders

        $pm_baseline_date_ids = BaselineDate::whereIn('equipment_id', $equipment_ids)->where('user_id', Auth::user()->id)->pluck('id');
        $user_pm_work_orders = PreventiveMaintenanceWorkOrder::whereIn('baseline_date_id', $pm_baseline_date_ids)->get();
        $user_dm_work_orders = DemandWorkOrder::whereIn('building_department_id', Auth::user()->departments->pluck('id'))->get();

        return view('equipment.work-order.index', ['pm_work_orders' => $pm_work_orders, 'demand_work_orders' => $demand_work_orders, 'equipments' => $equipments, 'ilsm_preassessment_questions' => $ilsm_preassessment_questions, 'ilsm_assessments' => $ilsm_assessments, 'work_order_statuses' => $work_order_statuses, 'user_pm_work_orders' => $user_pm_work_orders, 'user_dm_work_orders' => $user_dm_work_orders]);
    }
}
