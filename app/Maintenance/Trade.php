<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $table = 'maintenance_trades';

    protected $guarded = ['id'];

    public function problems()
    {
        return $this->hasMany('App\Maintenance\Problem', 'maintenance_trade_id');
    }
}
