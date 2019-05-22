<?php

namespace App\Tracer;

use Illuminate\Database\Eloquent\Model;
use App\Regulatory\Accreditation;

class ChecklistType extends Model
{
    protected $table = 'tracer_checklist_types';

    protected $fillable = ['name', 'tracer_section_id'];

    public function categories()
    {
        return $this->hasMany('App\Tracer\Category', 'checklist_type_id');
    }

    public function accreditations()
    {
        return $this->belongsToMany(Accreditation::class, 'tracer_checklist-accreditation', 'tracer_checklist_id', 'accreditation_id');
    }

    public function section()
    {
        return $this->belongsTo(ChecklistType::class, 'tracer_section_id');
    }
}
