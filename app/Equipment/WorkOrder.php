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

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
