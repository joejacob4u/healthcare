<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class BaselineDate extends Model
{
    protected $table = 'equipment_baseline_dates';

    protected $guarded = ['id'];

    protected $dates = [
        'date',
    ];

    public function equipment()
    {
        return $this->belongsTo('App\Equipment\Equipment', 'equipment_id');
    }

    public function inventories()
    {
        return $this->hasMany('App\Equipment\Inventory', 'baseline_date_id');
    }
}
