<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Model;

class RankingAnswer extends Model
{
    protected $table = 'project_ranking_answers';
    protected $fillable = ['question_id','answer','score'];

    public function question()
    {
        return $this->belongsTo('App\Project\RankingQuestion','question_id');
    }
}
