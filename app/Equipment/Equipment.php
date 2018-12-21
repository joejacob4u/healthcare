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
        return $this->hasManyThrough('App\Equipment\Inventory', 'App\Equipment\BaselineDate', 'equipment_id', 'baseline_date_id', 'id', 'id');
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
}
