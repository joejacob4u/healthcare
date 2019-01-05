<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'equipment_work_orders';

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
        return $this->hasMany('App\Equipment\WorkOrderInventory', 'equipment_work_order_id');
    }

    public function shifts()
    {
        return $this->hasMany('App\Equipment\WorkOrderShift', 'work_order_id');
    }

    public function hasInventories()
    {
        if ($this->workOrderInventories->count() > 0) {
            return true;
        }
        
        return false;
    }
}
