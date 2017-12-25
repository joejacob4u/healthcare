<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'project_equipment_documentation';

    public function projects()
    {
        return $this->belongsToMany('App\Project\Project','project_equipment','equipment_id','project_id')->withPivot('existing_equipment','replacement_equipment');

    }
}
