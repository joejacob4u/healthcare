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
        return $this->belongsTo('App\Equipment\PreventiveMaintenanceWorkOrder', 'equipment_work_order_id');
    }

    public function workOrderInventoryTimes()
    {
        return $this->hasMany('App\Equipment\WorkOrderInventoryTime', 'equipment_work_order_inventory_id');
    }



    public function avgTime()
    {
        //loop throught each inventory for the same baseline date

        $total_duration = 0;
        $inventory_count = 0;

        foreach ($this->workOrder->workOrderInventories as $work_order_inventory) {
            if ($work_order_inventory->equipment_inventory_id == $this->equipment_inventory_id && $work_order_inventory->workOrderStatus() == 'Complete and Compliant') {
                if (!$work_order_inventory->workOrderInventoryTimes->isEmpty()) {
                    $duration = 0;
        
                    foreach ($work_order_inventory->workOrderInventoryTimes as $time) {
                        $to_time = strtotime($time->end_time);
                        $from_time = strtotime($time->start_time);
                        $duration += round(abs($to_time - $from_time) / 60, 2);
                    }

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
        if (!$this->workOrderInventoryTimes->isEmpty() && $this->workOrderStatus() == 'Complete and Compliant') {
            $duration = 0;

            foreach ($this->workOrderInventoryTimes as $time) {
                $to_time = strtotime($time->end_time);
                $from_time = strtotime($time->start_time);
                $duration += round(abs($to_time - $from_time) / 60, 2);
            }

            return $duration;
        }


        return 'n/a';
    }

    public function workOrderStatus()
    {
        //get last status from inventory times

        if (!$this->workOrderInventoryTimes->isEmpty()) {
            return $this->workOrderInventoryTimes->last()->workOrderStatus->name;
        }

        return 'Pending';
    }
}
