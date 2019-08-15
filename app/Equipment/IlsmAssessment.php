<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class IlsmAssessment extends Model
{
    protected $table = 'ilsm_assessments';

    protected $fillable = [
        'work_order_id',
        'work_order_type',
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

    protected $casts = ['ilsm_preassessment_question_answers' => 'array', 'ilsm_question_answers' => 'array', 'ilsm_checklist_question_answers' => 'array'];

    public function work_order()
    {
        return $this->morphTo();
    }

    protected $dates = ['start_date', 'end_date'];

    public function status()
    {
        return $this->belongsTo('App\Equipment\IlsmAssessmentStatus', 'ilsm_assessment_status_id');
    }

    public function preAssessmentUser()
    {
        return $this->belongsTo('App\User', 'ilsm_preassessment_user_id');
    }

    public function ilsmQuestionApprovalUser()
    {
        return $this->belongsTo('App\User', 'ilsm_approve_user_id');
    }

    public function questionUser()
    {
        return $this->belongsTo('App\User', 'ilsm_question_user_id');
    }

    public function signOffUser()
    {
        return $this->belongsTo('App\User', 'ilsm_sign_off_user_id');
    }


    public function checklists()
    {
        return $this->hasMany('App\Equipment\IlsmChecklist', 'ilsm_assessment_id');
    }

    public function isChecklistComplete()
    {
        if ($this->checklists()->where('is_answered', 0)->orWhere('is_compliant', 0)->count() > 0) {
            return false;
        }

        return true;
    }

    public function applicableIlsms()
    {
        $applicable_ilsms = [];

        foreach ($this->ilsm_question_answers as $key => $answer) {
            $ilsm_question = \App\Equipment\IlsmQuestion::find($key);
            if ($answer) foreach ($ilsm_question->ilsms as $ilsm) : array_push($applicable_ilsms, $ilsm->id);
            endforeach;
        }

        return array_unique($applicable_ilsms);
    }
}
