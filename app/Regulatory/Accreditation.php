<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $table = 'accreditation';
    protected $fillable = ['name','slug'];

    public function accreditationRequirements()
    {
      return $this->belongsToMany('App\Regulatory\AccreditationRequirement','accr_accr-requirement','accrediation_id','accrediation-requirement_id');
    }

    public function standardLabels()
    {
      return $this->hasMany('App\Regulatory\StandardLabel','accreditation_id');
    }

    public function hcos()
    {
      return $this->belongsToMany('App\Regulatory\HCO','hco_accreditation','accreditation_id','hco_id');
    }
  

}
