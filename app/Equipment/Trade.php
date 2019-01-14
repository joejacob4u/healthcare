<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $table = 'work_order_trades';

    protected $guarded = ['id'];

    public function problems()
    {
        return $this->hasMany('App\Equipment\Problem', 'work_order_trade_id');
    }

    public function systemTier()
    {
        return $this->belongsTo('App\SystemTier', 'system_tier_id');
    }
}
