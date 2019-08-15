<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Equipment;
use App\Equipment\BaselineDate;
use App\Equipment\PreventiveMaintenanceWorkOrder;
use DateTime;
use DateInterval;
use DatePeriod;
use App\User;

class BaselineDateController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($equipment_id)
    {
        return view('equipment.baseline.index', ['equipment' => Equipment::find($equipment_id), 'users' => User::pluck('name', 'id')]);
    }

    public function store(Request $request, $equipment_id)
    {
        $this->validate($request, [
            'date' => 'required',
            'user_id' => 'not_in:0'
        ]);

        $equipment = Equipment::find($equipment_id);

        if ($baseline_date = $equipment->baselineDates()->create($request->all())) {

            //create work orders for this baseline date
            $this->create_work_orders($equipment, $baseline_date);

            return back()->with('success', 'Baseline created.');
        }
    }

    public function delete(Request $request)
    {
        if (BaselineDate::destroy($request->baseline_date_id)) {
            return response()->json(['status' => 'success']);
        }
    }

    private function create_work_orders($equipment, $baseline_date)
    {
        switch ($equipment->frequency) {
            case 'daily':
                $interval = 'P1D';
                $future_date_interval = '+1 day';
                break;

            case 'weekly':
                $interval = 'P1W';
                $future_date_interval = '+1 week';
                break;

            case 'monthly':
                $interval = 'P1M';
                $future_date_interval = '+1 month';
                break;

            case 'quarterly':
                $interval = 'P3M';
                $future_date_interval = '+3 month';
                break;

            case 'annually':
                $interval = 'P1Y';
                $future_date_interval = '+1 year';
                break;

            case 'two-years':
                $interval = 'P2Y';
                $future_date_interval = '+2 year';
                break;

            case 'three-years':
                $interval = 'P3Y';
                $future_date_interval = '+3 year';
                break;

            case 'four-years':
                $interval = 'P4Y';
                $future_date_interval = '+4 year';
                break;

            case 'five-years':
                $interval = 'P5Y';
                $future_date_interval = '+5 year';
                break;

            case 'six-years':
                $interval = 'P6Y';
                $future_date_interval = '+6 year';
                break;

            case 'semi-annually':
                $interval = 'P6M';
                $future_date_interval = '+6 month';
                break;

            case 'as-needed':
                return [];
                break;

            case 'per-policy':
                return [];
                break;
        }

        $from = new DateTime($baseline_date->date);

        $to = new DateTime(date('Y-m-d'));

        $to->modify($future_date_interval);

        $interval = new DateInterval($interval);

        $periods = new DatePeriod($from, $interval, $to);

        $dates = [];

        foreach ($periods as $period) {
            $dates[] = $period->format('Y-m-d');
        }

        //fetch existing dates

        $existing_dates = [];

        foreach ($baseline_date->workOrders as $work_order) {
            $existing_dates[] = $work_order->work_order_date;
        }

        $work_order_dates = array_diff($dates, $existing_dates);

        //save work order dates

        foreach ($work_order_dates as $work_order_date) {

            $preventive_maintenance_work_order = PreventiveMaintenanceWorkOrder::create([
                'name' => 'Work Order for ' . date('F j, Y', strtotime($work_order_date)),
                'work_order_date' => $work_order_date,
                'building_id' => session('building_id'),
                'baseline_date_id' => $baseline_date->id,
                'equipment_id' => $equipment->id,
                'is_in_house' => 1
            ]);

            $preventive_maintenance_work_order->ilsmAssessment()->create(['ilsm_assessment_status_id' => 8]);
        }
    }
}
