<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrderPriority extends Model
{
    protected $table = 'work_order_priorities';

    protected $guarded = ['id'];

    public function demandWorkOrders()
    {
        return $this->hasMany('App\Equipment\DemandWorkOrder', 'work_order_priority_id');
    }
}
