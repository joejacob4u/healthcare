<?php

namespace App\Workflow;

use Illuminate\Database\Eloquent\Model;

class ApprovalLevelLeader extends Model
{
    protected $table = 'approval_level_leaders';
    protected $guarded = ['id'];
}
