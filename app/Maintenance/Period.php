<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = 'maintenance_shift_periods';

    protected $guarded = ['id'];

    public function shift()
    {
        return $this->belongsTo('App\Maintenance\Shift', 'maintenance_shift_id');
    }
}
