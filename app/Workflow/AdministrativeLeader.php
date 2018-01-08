<?php

namespace App\Workflow;

use Illuminate\Database\Eloquent\Model;

class AdministrativeLeader extends Model
{
    protected $table = 'administrative_leaders';
    protected $guarded = ['id'];

    public function approvalLevelLeader()
    {
        return $this->belongsTo('App\Workflow\ApprovalLevelLeader','workflow_approval_level_leader_id');
    }
}
