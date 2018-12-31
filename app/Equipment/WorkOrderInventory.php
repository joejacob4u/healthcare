<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrderInventory extends Model
{
    protected $table = 'equipment_work_order_inventory';

    protected $guarded = ['id'];

    protected $dates = [];

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
}
