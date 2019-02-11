<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;
use App\Maintenance\Shift;

class DemandWorkOrder extends Model
{
    protected $table = 'demand_work_orders';

    protected $guarded = ['id'];

    protected $dates = ['created_at'];

    protected $appends = ['identifier'];

    public function priority()
    {
        return $this->belongsTo('App\Equipment\WorkOrderPriority', 'work_order_priority_id');
    }

    public function inventory()
    {
        return $this->belongsTo('App\Equipment\Inventory', 'inventory_id');
    }

    public function hco()
    {
        return $this->belongsTo('App\Regulatory\HCO', 'hco_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Regulatory\BuildingDepartment', 'building_department_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Regulatory\Room', 'room_id');
    }

    public function trade()
    {
        return $this->belongsTo('App\Equipment\Trade', 'work_order_trade_id');
    }

    public function problem()
    {
        return $this->belongsTo('App\Equipment\Problem', 'work_order_problem_id');
    }

    public function shifts()
    {
        return $this->hasMany('App\Equipment\DemandWorkOrderShift', 'demand_work_order_id');
    }

    //accessor for work order identifier

    public function getIdentifierAttribute()
    {
        return 'DM-'.unixtojd($this->created_at->timestamp).'-'.$this->id;
    }

    public function status()
    {
        if (count($this->shifts) > 0) {
            return $this->shifts->last()->status->name;
        } else {
            return 'Pending';
        }
    }

    public function getMaintenanceShift()
    {
        $day = strtolower(strftime('%A', strtotime($this->created_at)));
        $maintenance_shifts = Shift::where('hco_id', session('hco_id'))->where('days', 'LIKE', '%'.$day.'%')->get();
        
        foreach ($maintenance_shifts as $maintenance_shift) {
            $start_time = str_replace(':', '', $maintenance_shift->start_time);
            $end_time = str_replace(':', '', $maintenance_shift->end_time);
            $demand_work_order_time = str_replace(':', '', $this->created_at);
            
            if ($end_time > $start_time) {
                if ($start_time <= $demand_work_order_time && $end_time >= $demand_work_order_time) {
                    return $maintenance_shift;
                }
            } else {
                if ($start_time >= $demand_work_order_time && $end_time >= $demand_work_order_time) {
                    return $maintenance_shift;
                }
            }
        }

        return false;
    }
}
