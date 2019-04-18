<?php

namespace App\Assessment;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'assessment_sections';

    protected $guarded = ['id'];

    public function checklistTypes()
    {
        return $this->hasMany(ChecklistType::class, 'assessment_section_id');
    }
}
