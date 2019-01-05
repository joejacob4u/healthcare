<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class WorkOrderShift extends Model
{
    protected $table = 'equipment_work_order_shifts';

    protected $guarded = ['id'];

    protected $dates = ['start_time','end_time'];

    public function workOrder()
    {
        return $this->belongsTo('App\Equipment\WorkOrderShift', 'work_order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
