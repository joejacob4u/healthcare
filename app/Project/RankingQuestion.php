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
}
