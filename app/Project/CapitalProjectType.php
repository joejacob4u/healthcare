<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Model;

class CapitalProjectType extends Model
{
    protected $table = 'capital_project_types';
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany('App\Project\Project');
    }
}


