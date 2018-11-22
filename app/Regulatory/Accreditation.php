<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $table = 'accreditation';
    protected $fillable = ['name','slug'];

    public function accreditationRequirements()
    {
        return $this->belongsToMany('App\Regulatory\AccreditationRequirement', 'accr_accr-requirement', 'accrediation_id', 'accrediation-requirement_id');
    }

    public function standardLabels()
    {
        return $this->belongsToMany('App\Regulatory\StandardLabel', 'accreditations-standard_labels', 'accreditation_id', 'standard_label_id');
    }

    public function hcos()
    {
        return $this->belongsToMany('App\Regulatory\HCO', 'hco_accreditation', 'accreditation_id', 'hco_id');
    }

    public function eops()
    {
        return $this->belongsToMany('App\Regulatory\EOP', 'accreditations_eops', 'accreditation_id', 'eop_id');
    }
}
