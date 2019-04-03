<?php

namespace App\Rounding;

use Illuminate\Database\Eloquent\Model;
use App\User;

class QuestionFinding extends Model
{
    protected $table = 'rounding_question_findings';

    protected $fillable = ['rounding_id','question_id','user_id','finding','is_leader'];

    protected $casts = ['finding' => 'array'];

    public function rounding()
    {
        return $this->belongsTo(Rounding::class, 'rounding_id');
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
