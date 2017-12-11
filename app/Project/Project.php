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
}
