<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class DemandWorkOrder extends Model
{
    protected $table = 'demand_work_orders';

    protected $guarded = ['id'];

    public function priority()
    {
        return $this->belongsTo('App\Equipment\WorkOrderPriority', 'work_order_priority_id');
    }
}
