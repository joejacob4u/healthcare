<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateInterval;
use DatePeriod;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $guarded = ['id'];

    public function inventories()
    {
        return $this->hasManyThrough();
    }

    public function baselineDates()
    {
        return $this->hasMany('App\Equipment\BaselineDate', 'equipment_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }


    public function category()
    {
        return $this->belongsTo('App\Equipment\Category', 'equipment_category_id');
    }



    public function assetCategory()
    {
        return $this->belongsTo('App\Equipment\AssetCategory', 'equipment_asset_category_id');
    }

    public function maintenanceRequirement()
    {
        return $this->belongsTo('App\Equipment\MaintenanceRequirement', 'equipment_maintenance_requirement_id');
    }


    public function workOrders()
    {
        return $this->hasMany('App\Equipment\WorkOrder', 'equipment_id');
    }

    public function lastWorkOrderStatus()
    {
        $status = 1;

        foreach ($this->workOrders as $work_order) {
            foreach ($work_order->workOrderStatuses() as $work_order_status) {
                if ($work_order_status->id > $status) {
                    $status = $work_order_status->id;
                }
            }
        }

        return WorkOrderStatus::find($status)->name;
    }
    



    public function calculateEquipmentWorkOrderDates()
    {
        switch ($this->frequency) {
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

        $from = new DateTime($this->baseline_date);

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

        foreach ($this->workOrders as $work_order) {
            $existing_dates[] = $work_order->work_order_date;
        }

        return array_diff($dates, $existing_dates);
    }
}
