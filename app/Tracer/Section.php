<?php

namespace App\Tracer;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'tracer_sections';

    protected $guarded = ['id'];

    public function checklistTypes()
    {
        return $this->hasMany(ChecklistType::class, 'tracer_section_id');
    }
}
