<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'equipment_work_orders';

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'work_order_date'
    ];

    public function equipment()
    {
        return $this->belongsTo('App\Equipment\Equipment', 'equipment_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function baselineDate()
    {
        return $this->belongsTo('App\Equipment\BaselineDate', 'baseline_date_id');
    }

    public function workOrderInventories()
    {
        return $this->hasMany('App\Equipment\WorkOrderInventory', 'equipment_work_order_id');
    }

    public function shifts()
    {
        return $this->hasMany('App\Equipment\WorkOrderShift', 'work_order_id');
    }

    public function hasInventories()
    {
        if ($this->workOrderInventories->count() > 0) {
            return true;
        }

        return false;
    }

    public function status()
    {
        $statuses = [];
        
        foreach ($this->workOrderInventories as $inventory) {
            if (!$inventory->workOrderInventoryTimes->isEmpty()) {
                $statuses[] = $inventory->workOrderInventoryTimes->last()->workOrderStatus->id;
            }
        }

        if (!empty($statuses)) {
            return WorkOrderStatus::find(max($statuses))->name;
        } else {
            return 'Pending';
        }
    }

    public function isComplete()
    {
        //check if all inventories under that work order are compliant

        foreach ($this->workOrderInventories as $inventory) {
            if (!$inventory->workOrderInventoryTimes->isEmpty()) {
                if ($inventory->workOrderInventoryTimes->last()->workOrderStatus->id != 1) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public function avgDuration()
    {
        //iterate thru all work orders for the baseline date

        $avgDuration = 0;
        $count = 0;

        foreach ($this->baselineDate->workOrders as $workOrder) {
            if ($workOrder->isComplete()) {
                foreach ($workOrder->workOrderInventories as $workOrderInventory) {
                    $avgDuration += $workOrderInventory->avgTime();
                }
                
                $count++;
            }
        }

        if ($count > 0) {
            return intval($avgDuration / $count);
        } else {
            return 'n/a';
        }
    }

    public function duration()
    {
        $count = 0;
        $duration = 0;

        if ($this->isComplete()) {
            foreach ($this->workOrderInventories as $workOrderInventory) {
                $duration += $workOrderInventory->duration();
                $count++;
            }
        }

        if ($count > 0) {
            return intval($duration / $count);
        } else {
            return 'n/a';
        }
    }
}
