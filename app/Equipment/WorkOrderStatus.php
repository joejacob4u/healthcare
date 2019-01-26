<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrderStatus extends Model
{
    protected $table = 'equipment_work_order_statuses';

    protected $guarded = ['id'];

    public function workOrders()
    {
        return $this->belongsToMany('App\Equipment\PreventiveMaintenanceWorkOrder', 'equipment_work_order-equipment_work_order_status', 'equipment_work_order_status_id', 'equipment_work_order_id');
    }
}
