<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Model;

class RankingQuestion extends Model
{
    protected $table = 'project_ranking_questions';

    protected $fillable = ['question'];

    public function answers()
    {
        return $this->hasMany('App\Project\RankingAnswer','question_id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project\Project','project_ranking_results','question_id','project_id')->withPivot('answer_id');
    }
}
