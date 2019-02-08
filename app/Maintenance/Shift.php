<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'maintenance_shifts';

    protected $guarded = ['id'];

    protected $casts = ['days' => 'array'];


    /**
     * periods
     *
     * @return Collection
     */

    public function periods()
    {
        return $this->hasMany('App\Maintenance\Period', 'maintenance_shift_id');
    }

    public function hco()
    {
        return $this->belongsTo('App\Regulatory\HCO', 'hco_id');
    }
}
