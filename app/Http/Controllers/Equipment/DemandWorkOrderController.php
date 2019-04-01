<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;
use App\Equipment\Trade;
use App\Equipment\WorkOrderPriority;
use App\Equipment\DemandWorkOrder;
use App\Equipment\WorkOrderStatus;

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

    public function show($demand_work_order_id)
    {
        $demand_work_order = DemandWorkOrder::find($demand_work_order_id);
        $work_order_statuses = WorkOrderStatus::pluck('name', 'id');
        return view('equipment.work-order.demand', ['demand_work_order' => $demand_work_order,'work_order_statuses' => $work_order_statuses]);
    }

    public function store(Request $request)
    {
        if ($demand_work_order = DemandWorkOrder::create($request->except('rooms'))) {
            if (!empty($request->rooms)) {
                $demand_work_order->rooms()->sync($request->rooms);
            }
            //create ilsm assessment record
            if ($demand_work_order->ilsmAssessment()->create(['ilsm_assessment_status_id' => 8])) {
                return back()->with('success', 'Demand work order created!');
            }
        }
    }

    public function preAssessment(Request $request)
    {
        $this->validate($request, [
            'ilsm_preassessment_question_1' => 'required',
            'ilsm_preassessment_question_2' => 'required_if:ilsm_preassessment_question_1,0',
            'ilsm_preassessment_question_3' => 'required_if:ilsm_preassessment_question_2,1'
        ]);

        $flags = ['is_ilsm' => 0,'is_ilsm_probable' => 0];

        $demand_work_order = DemandWorkOrder::find($request->demand_work_order_id);

        if ($request->ilsm_preassessment_question_1 == 1 || $request->ilsm_preassessment_question_3 == 1) {
            $flags = ['is_ilsm' => 1,'is_ilsm_probable' => 0,'is_ilsm_pre_assessment_completed' => 1];
        } else {
            $flags = ['is_ilsm' => 0,'is_ilsm_probable' => 0,'is_ilsm_pre_assessment_completed' => 1];
        }

        $request->request->add($flags);

        if ($demand_work_order->update($request->except(['demand_work_order_id']))) {
            return redirect('/equipment/demand-work-orders/'.$demand_work_order->id);
        }
    }
}
