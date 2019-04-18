<?php

namespace App\Assessment;

use Illuminate\Database\Eloquent\Model;
use App\Regulatory\Accreditation;

class ChecklistType extends Model
{
    protected $table = 'assessment_checklist_types';

    protected $fillable = ['name', 'assessment_section_id'];

    public function categories()
    {
        return $this->hasMany('App\Assessment\Category', 'checklist_type_id');
    }

    public function accreditations()
    {
        return $this->belongsToMany(Accreditation::class, 'assessment_checklist-accreditation', 'assessment_checklist_id', 'accreditation_id');
    }

    public function section()
    {
        return $this->belongsTo(ChecklistType::class, 'assessment_section_id');
    }
}
