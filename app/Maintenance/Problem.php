<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = 'maintenance_problems';

    protected $guarded = ['id'];

    public function trade()
    {
        return $this->belongsTo('App\Maintenance\Problem', 'maintenance_trade_id');
    }
}
