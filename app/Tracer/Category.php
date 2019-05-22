<?php

namespace App\Tracer;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tracer_categories';

    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany('App\Tracer\Question', 'tracer_category_id');
    }

    public function checklistType()
    {
        return $this->belongsTo('App\Tracer\ChecklistType', 'tracer_type_id');
    }
}
