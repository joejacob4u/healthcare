<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;
use App\Assessment\Question;

class EOPFinding extends Model
{
    protected $table = 'eop_findings';
    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany('App\Regulatory\EOPFindingComment', 'eop_finding_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function eop()
    {
        return $this->belongsTo('App\Regulatory\EOP', 'eop_id');
    }

    public function site()
    {
        return $this->belongsTo('App\Regulatory\Site', 'site_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Regulatory\BuildingDepartment', 'department_id');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Regulatory\Room', 'eop_finding-room', 'eop_finding_id', 'room_id');
    }

    public function lastAssigned()
    {
        return $this->belongsTo('App\User', 'last_assigned_user_id');
    }

    public function assessmentQuestions()
    {
        return $this->belongsToMany(Question::class, 'assessment_question-finding', 'finding_id', 'assessment_question_id')->withPivot(['assessment_id']);
    }

    public function statusColor()
    {
        switch ($this->status) {
            case 'initial':
                return 'danger';
                break;

            case 'non-compliant':
                return 'danger';
                break;

            case 'compliant':
                return 'success';
                break;

            case 'pending_verification':
                return 'warning';
                break;

            case 'issues_corrected_verify':
                return 'warning';
                break;

            default:
                return 'primary';
                break;
        }
    }

    public function scopeUnassigned($query)
    {
        return $query->where('created_by_user_id', '')->where('last_assigned_user_id', '');
    }

    public function scopeAssigned($query)
    {
        return $query->where('created_by_user_id', '!=', '')->where('last_assigned_user_id', '!=', '');
    }

    public function isNotAssigned()
    {
        if (empty($this->created_by_user_id) && empty($this->last_assigned_user_id)) {
            return true;
        }

        return false;
    }
}
