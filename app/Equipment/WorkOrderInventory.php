<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrderInventory extends Model
{
    protected $table = 'equipment_work_order_inventory';

    protected $guarded = ['id'];

    protected $dates = ['updated_at'];

    public function inventory()
    {
        return $this->belongsTo('App\Equipment\Inventory', 'equipment_inventory_id');
    }

    public function workOrder()
    {
        return $this->belongsTo('App\Equipment\WorkOrder', 'equipment_work_order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function workOrderStatus()
    {
        return $this->belongsTo('App\Equipment\WorkOrderStatus', 'equipment_work_order_status_id');
    }

    public function avgTime()
    {
        //loop throught each inventory for the same baseline date

        $total_duration = 0;
        $inventory_count = 0;

        foreach ($this->workOrder->workOrderInventories as $work_order_inventory) {
            if ($work_order_inventory->equipment_inventory_id == $this->equipment_inventory_id && $work_order_inventory->equipment_work_order_status_id == 1) {
                if (!empty($work_order_inventory->start_time) && !empty($work_order_inventory->end_time)) {
                    $to_time = strtotime($work_order_inventory->end_time);
                    $from_time = strtotime($work_order_inventory->start_time);
                    $duration = round(abs($to_time - $from_time) / 60, 2);
                    $total_duration += $duration;
                    $inventory_count++;
                }
            }
        }

        if ($inventory_count > 0) {
            return intval($total_duration / $inventory_count) ; // return in mins as whole number
        } else {
            return 'N/A';
        }
    }

    public function duration()
    {
        if (!empty($this->start_time) && !empty($this->end_time)) {
            $to_time = strtotime($this->end_time);
            $from_time = strtotime($this->start_time);
            $duration = round(abs($to_time - $from_time) / 60, 2);
            return $duration;
        }

        return 'n/a';
    }
}
