<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $guarded = ['id']; 

    public function buildings()
    {
        return $this->belongsToMany('App\Regulatory\Building','project_building','project_id','building_id');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Project\RankingQuestion','project_ranking_results','project_id','question_id')->withPivot('answer_id');
    }

    public function equipments()
    {
        return $this->belongsToMany('App\Project\Equipment','project_equipment','project_id','equipment_id')->withPivot('existing_equipment','replacement_equipment');
    }

}
