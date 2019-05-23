<?php

namespace App\Tracer;

use Illuminate\Database\Eloquent\Model;
use App\Regulatory\EOPFinding;
use App\Equipment\DemandWorkOrder;

class Tracer extends Model
{
    protected $table = 'tracers';

    protected $guarded = ['id'];

    public function status()
    {
        return $this->belongsTo('App\Rounding\Status', 'tracer_status_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Tracer\Section', 'tracer_section_id');
    }

    public function checklistType()
    {
        return $this->belongsTo('App\Tracer\ChecklistType', 'tracer_checklist_type_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Regulatory\BuildingDepartment', 'building_department_id');
    }

    public function workOrders()
    {
        return $this->belongsToMany(DemandWorkOrder::class, 'tracer_question-work_order', 'tracer_id', 'work_order_id')->withPivot(['tracer_question_id']);
    }

    public function eopFindings()
    {
        return $this->belongsToMany(EOPFinding::class, 'tracer_question-finding', 'tracer_id', 'finding_id')->withPivot(['tracer_question_id']);
    }

    public function evaluations()
    {
        return $this->hasMany(QuestionEvaluation::class, 'tracer_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function setCreatedAtAttribute($date)
    {
        return $this->attributes['created_at'] = \Carbon\Carbon::parse($date, session('timezone'))->setTimezone('UTC');
    }


    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date, 'UTC')->setTimezone(session('timezone'));
    }
}
