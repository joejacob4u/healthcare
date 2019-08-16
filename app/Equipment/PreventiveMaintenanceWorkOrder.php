<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;
use App\Maintenance\Shift;

class PreventiveMaintenanceWorkOrder extends Model
{
    protected $table = 'preventive_maintenance_work_orders';

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
        return $this->hasMany('App\Equipment\PreventiveMaintenanceWorkOrderInventory', 'equipment_work_order_id');
    }

    public function shifts()
    {
        return $this->hasMany('App\Equipment\WorkOrderShift', 'work_order_id');
    }

    public function ilsmAssessment()
    {
        return $this->morphOne('App\Equipment\IlsmAssessment', 'work_order');
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
            if (!$inventory->PreventiveMaintenanceWorkOrderInventoryTimes->isEmpty()) {
                $statuses[] = $inventory->PreventiveMaintenanceWorkOrderInventoryTimes->last()->workOrderStatus->id;
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
            if (!$inventory->PreventiveMaintenanceWorkOrderInventoryTimes->isEmpty()) {
                if ($inventory->PreventiveMaintenanceWorkOrderInventoryTimes->last()->workOrderStatus->id != 1) {
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
                foreach ($workOrder->workOrderInventories as $PreventiveMaintenanceWorkOrderInventory) {
                    $avgDuration += $PreventiveMaintenanceWorkOrderInventory->avgTime();
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
            foreach ($this->workOrderInventories as $PreventiveMaintenanceWorkOrderInventory) {
                $duration += $PreventiveMaintenanceWorkOrderInventory->duration();
                $count++;
            }
        }

        if ($count > 0) {
            return intval($duration / $count);
        } else {
            return 'n/a';
        }
    }

    //accessor for work order identifier

    public function getIdentifierAttribute()
    {
        return 'PM-' . unixtojd($this->created_at->timestamp) . '-' . $this->id;
    }

    public function getMaintenanceShift()
    {
        $day = strtolower(strftime('%A', strtotime($this->created_at)));
        $maintenance_shifts = Shift::where('hco_id', session('hco_id'))->where('days', 'LIKE', '%' . $day . '%')->get();

        foreach ($maintenance_shifts as $maintenance_shift) {
            $start_time = str_replace(':', '', $maintenance_shift->start_time);
            $end_time = str_replace(':', '', $maintenance_shift->end_time);
            $pm_work_order_time = str_replace(':', '', $this->created_at->format('H:i:s'));

            if ($end_time > $start_time) {
                if ($start_time <= $pm_work_order_time && $end_time >= $pm_work_order_time) {
                    return $maintenance_shift;
                }
            } else {
                if ($start_time >= $pm_work_order_time && $end_time >= $pm_work_order_time) {
                    return $maintenance_shift;
                }
            }
        }

        return false;
    }

    //accessor for ilsm probable

    public function getIsIlsmProbableAttribute()
    {
        if ($this->ilsmAssessment->ilsm_assessment_status_id == '1') {
            return true;
        }

        return false;
    }

    public function getIsIlsmAttribute()
    {
        if (in_array($this->ilsmAssessment->ilsm_assessment_status_id, [3, 4, 5, 6])) {
            return true;
        }

        return false;
    }

    public function getIsIlsmCompleteAttribute()
    {
        if (in_array($this->ilsmAssessment->ilsm_assessment_status_id, [7])) {
            return true;
        }

        return false;
    }
}
