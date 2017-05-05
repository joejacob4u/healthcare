<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class AccreditationRequirement extends Model
{
    protected $table = 'accrediation_requirements';
    protected $fillable = ['name'];

    public function accreditations()
    {
      return $this->belongsToMany('App\Regulatory\Accreditation','accr_accr-requirement','accrediation-requirement_id','accrediation_id');
    }

    public function standardLabels()
    {
      return $this->belongsToMany('App\Regulatory\StandardLabel','standard-label_accrediation-requirement','accrediation_requirement_id','standard_label_id');
    }

}
