<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = 'work_order_problems';

    protected $guarded = ['id'];

    public function trade()
    {
        return $this->belongsTo('App\Equipment\Trade', 'work_order_trade_id');
    }

    public function priority()
    {
        return $this->belongsTo('App\Equipment\WorkOrderPriority', 'work_order_priority_id');
    }
}
