<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrderInventoryTime extends Model
{
    protected $table = 'equipment_work_order_inventory_times';

    protected $guarded = ['id'];

    public function workOrderInventory()
    {
        return $this->belongsTo('App\Equipment\WorkOrderInventory', 'equipment_work_order_inventory_id');
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
