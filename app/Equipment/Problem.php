<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = 'work_order_problems';

    protected $guarded = ['id'];

    protected $appends=['full_name'];

    public function trade()
    {
        return $this->belongsTo('App\Equipment\Trade', 'work_order_trade_id');
    }

    public function priority()
    {
        return $this->belongsTo('App\Equipment\WorkOrderPriority', 'work_order_priority_id');
    }

    public function eops()
    {
        return $this->belongsToMany('App\Regulatory\EOP', 'eop_problem', 'work_order_problem_id', 'eop_id');
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' (' . $this->trade->name .' )';
    }
}
