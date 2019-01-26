<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class DemandWorkOrder extends Model
{
    protected $table = 'demand_work_orders';

    protected $guarded = ['id'];

    protected $dates = ['created_at'];

    public function priority()
    {
        return $this->belongsTo('App\Equipment\WorkOrderPriority', 'work_order_priority_id');
    }

    public function inventory()
    {
        return $this->belongsTo('App\Equipment\Inventory','inventory_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Regulatory\BuildingDepartment','building_department_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Regulatory\Room','room_id');
    }

    public function trade()
    {
        return $this->belongsTo('App\Equipment\Trade','work_order_trade_id');
    }

    public function problem()
    {
        return $this->belongsTo('App\Equipment\Problem','work_order_problem_id');
    }

}
