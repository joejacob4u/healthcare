<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class IlsmChecklist extends Model
{
    protected $table = 'ilsm_checklists';

    protected $fillable = ['ilsm_assessment_id','ilsm_id','answers','is_answered','is_compliant','date'];

    protected $casts = ['answers' => 'array'];

    protected $appends = ['is_compliant'];

    protected $dates = ['date'];

    public function ilsm()
    {
        return $this->belongsTo('App\Equipment\Ilsm', 'ilsm_id');
    }

    public function ilsmAssessment()
    {
        return $this->belongsTo('App\Equipment\IlsmAssessment', 'ilsm_assessment_id');
    }

    public function setIsCompliantAttribute()
    {
        if (empty($this->answers)) {
            return false;
        }

        foreach ($this->answers as $key => $answer) {
            if ($key != 'attachment' && $answer['answer'] == 'no') {
                return false;
            }
        }

        return true;
    }
}
