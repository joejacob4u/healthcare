<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class IlsmAssessment extends Model
{
    protected $table = 'ilsm_assessments';

    protected $fillable = [
        'demand_work_order_id',
        'ilsm_preassessment_question_answers',
        'ilsm_preassessment_user_id',
        'ilsm_question_answers',
        'ilsm_question_user_id',
        'ilsm_approve_user_id',
        'start_date',
        'end_date',
        'ilsm_checklist_question_answers',
        'is_checklist_completed',
        'ilsm_sign_off_user_id',
        'ilsm_assessment_status_id'
    ];

    protected $casts = ['ilsm_preassessment_question_answers' => 'array','ilsm_question_answers' => 'array','ilsm_checklist_question_answers' => 'array'];

    protected $dates = ['start_date','end_date'];

    public function demandWorkOrder()
    {
        return $this->belongsTo('App\Equipment\DemandWorkOrder', 'demand_work_order_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Equipment\IlsmAssessmentStatus', 'ilsm_assessment_status_id');
    }

    public function preAssessmentUser()
    {
        return $this->belongsTo('App\User', 'ilsm_preassessment_user_id');
    }

    public function questionUser()
    {
        return $this->belongsTo('App\User', 'ilsm_question_user_id');
    }
}
