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


    public function workOrderStatuses()
    {
        return $this->belongsToMany('App\Equipment\WorkOrderStatus', 'equipment_work_order-equipment_work_order_status', 'equipment_work_order_id', 'equipment_work_order_status_id')->withPivot('comment', 'attachment', 'user_id', 'start_time', 'end_time');
    }

    public function getLastWorkOrderStatus()
    {
        return $this->workOrderStatuses->last()->name;
    }
}
