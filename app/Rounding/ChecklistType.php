<?php

namespace App\Rounding;

use Illuminate\Database\Eloquent\Model;

class ChecklistType extends Model
{
    protected $table = 'rounding_checklist_types';

    protected $fillable = ['name'];

    public function categories()
    {
        return $this->hasMany('App\Rounding\Category', 'checklist_type_id');
    }
}
