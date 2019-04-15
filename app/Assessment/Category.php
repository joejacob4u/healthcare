<?php

namespace App\Assessment;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'assessment_categories';

    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany('App\Assessment\Question', 'assessment_category_id');
    }

    public function checklistType()
    {
        return $this->belongsTo('App\Assessment\ChecklistType', 'checklist_type_id');
    }
}
