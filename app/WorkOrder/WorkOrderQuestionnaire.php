<?php

namespace App\WorkOrder;

use Illuminate\Database\Eloquent\Model;

class WorkOrderQuestionnaire extends Model
{
    protected $table = 'work_order_questionnaires';

    protected $guarded = ['id'];

    public function systemTier()
    {
        return $this->belongsTo('App\SystemTier', 'system_tier_id');
    }
}
