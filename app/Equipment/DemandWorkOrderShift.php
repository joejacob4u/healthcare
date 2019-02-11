<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class DemandWorkOrderShift extends Model
{
    protected $table = 'demand_work_order_shifts';

    protected $guarded = ['id'];

    protected $dates = ['start_time','end_time','created_at'];

    public function demandWorkOrder()
    {
        return $this->belongsTo('App\Equipment\DemandWorkOrder', 'demand_work_order_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Equipment\WorkOrderStatus', 'equipment_work_order_status_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function setEndTimeAttribute($date)
    {
        return $this->attributes['end_time'] = \Carbon\Carbon::parse($date, session('timezone'))->setTimezone('UTC');
    }

    public function setStartTimeAttribute($date)
    {
        return $this->attributes['start_time'] = \Carbon\Carbon::parse($date, session('timezone'))->setTimezone('UTC');
    }

    public function getEndTimeAttribute($date)
    {
        return \Carbon\Carbon::parse($date, 'UTC')->setTimezone(session('timezone'));
    }

    public function getStartTimeAttribute($date)
    {
        return \Carbon\Carbon::parse($date, 'UTC')->setTimezone(session('timezone'));
    }

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date, 'UTC')->setTimezone(session('timezone'));
    }
}
