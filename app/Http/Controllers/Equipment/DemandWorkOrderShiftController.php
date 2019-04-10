<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\DemandWorkOrder;
use App\Equipment\DemandWorkOrderShift;
use App\Rounding\Rounding;

class DemandWorkOrderShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function store(Request $request, $demand_work_order_id)
    {
        $demand_work_order = DemandWorkOrder::find($demand_work_order_id);

        if ($shift = $demand_work_order->shifts()->create($request->all())) {
            if ($this->is_ilsm($shift)) {
                $demand_work_order->ilsmAssessment()->update(['ilsm_assessment_status_id' => 1]);
            }

            $this->rounding_question_work_orders($demand_work_order);
            return response()->json(['status' => 'success']);
        }
    }

    public function delete(Request $request)
    {
        if (DemandWorkOrderShift::destroy($request->shift_id)) {
            return response()->json(['status' => 'success']);
        }
    }

    private function is_ilsm(DemandWorkOrderShift $shift)
    {
        if (count($shift->demandWorkOrder->problem->eops) > 0) {
            foreach ($shift->demandWorkOrder->problem->eops as $eop) {

                //check for ilsm first
                if ($eop->is_ilsm) {
                    //if ilsm , lets check for shift first
                    if ($eop->is_ilsm_shift) {
                        //lets get matching shift for the demand order
                        $corresponding_shift = $shift->demandWorkOrder->getMaintenanceShift();

                        if ($corresponding_shift !== false) {
                            $corresponding_shift_time = \Carbon\Carbon::parse($shift->demandWorkOrder->created_at->format('Y-m-d') . ' ' . $corresponding_shift->end_time);

                            if ($corresponding_shift_time->lessThan($shift->end_time)) {
                                return true;
                            }
                        }
                    } elseif (!empty($eop->ilsm_hours_threshold)) {
                        $allowed_date = $shift->demandWorkOrder->created_at->addHours($eop->ilsm_hours_threshold);

                        if ($allowed_date->lessThan($shift->end_time)) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    private function rounding_question_work_orders(DemandWorkOrder $demand_work_order)
    {
        //trigger rounding work orders if any

        if ($demand_work_order->roundingQuestions->count() > 0) {
            $is_compliant = true;

            $rounding = Rounding::find($demand_work_order->roundingQuestions->first()->pivot->rounding_id);

            //loop thru each work order for the rounding
            foreach ($rounding->workOrders as $work_order) {
                if ($work_order->status() != 'Complete and Compliant') {
                    $is_compliant = false;
                }
            }

            $rounding->update(['rounding_status_id' => ($is_compliant) ? 4 : 5]);
        }
    }
}
