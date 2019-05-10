<?php

namespace App\Assessment;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Equipment\DemandWorkOrder;

class QuestionEvaluation extends Model
{
    protected $table = 'assessment_question_evaluations';

    protected $fillable = ['assessment_id', 'question_id', 'user_id', 'finding', 'is_leader'];

    protected $casts = ['finding' => 'array'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'rounding_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setCreatedAttribute($date)
    {
        return $this->attributes['created_at'] = \Carbon\Carbon::parse($date, session('timezone'))->setTimezone('UTC');
    }


    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date, 'UTC')->setTimezone(session('timezone'));
    }
}
