<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class PreventiveMaintenanceWorkOrderInventory extends Model
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

    public function PreventiveMaintenanceWorkOrderInventoryTimes()
    {
        return $this->hasMany('App\Equipment\PreventiveMaintenanceWorkOrderInventoryTime', 'equipment_work_order_inventory_id');
    }



    public function avgTime()
    {
        //loop throught each inventory for the same baseline date

        $total_duration = 0;
        $inventory_count = 0;

        foreach ($this->workOrder->workOrderInventories as $work_order_inventory) {
            if ($work_order_inventory->equipment_inventory_id == $this->equipment_inventory_id && $work_order_inventory->workOrderStatus() == 'Complete and Compliant') {
                if (!$work_order_inventory->PreventiveMaintenanceWorkOrderInventoryTimes->isEmpty()) {
                    $duration = 0;
        
                    foreach ($work_order_inventory->PreventiveMaintenanceWorkOrderInventoryTimes as $time) {
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
        if (!$this->PreventiveMaintenanceWorkOrderInventoryTimes->isEmpty() && $this->workOrderStatus() == 'Complete and Compliant') {
            $duration = 0;

            foreach ($this->PreventiveMaintenanceWorkOrderInventoryTimes as $time) {
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

        if (!$this->PreventiveMaintenanceWorkOrderInventoryTimes->isEmpty()) {
            return $this->PreventiveMaintenanceWorkOrderInventoryTimes->last()->workOrderStatus->name;
        }

        return 'Pending';
    }
}
