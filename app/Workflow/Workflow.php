<?php

namespace App\Workflow;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $table = 'workflows';
    protected $guarded = ['id'];

    public function approvalLevelLeaders()
    {
        return $this->belongsToMany('App\Workflow\ApprovalLevelLeader','workflow_approval_level_leader','workflow_id','approval_leader_id');
    }

    public function administrativeLeaders()
    {
        return $this->belongsToMany('App\Workflow\AdministrativeLeader','workflow_administrative_leader','workflow_id','administrative_leader_id');
    }

    public function accreditationComplianceLeaders()
    {
        return $this->belongsToMany('App\Workflow\AccreditationComplainceLeader','workflow_accreditation_compliance_leader','workflow_id','accreditation_compliance_leader_id');
    }

}
