<?php

namespace App\Rounding;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'rounding_categories';

    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany('App\Rounding\Question', 'rounding_category_id');
    }

    public function checklistType()
    {
        return $this->belongsTo('App\Rounding\ChecklistType', 'checklist_type_id');
    }
}
