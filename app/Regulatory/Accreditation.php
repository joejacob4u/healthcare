<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $table = 'accrediation';
    protected $fillable = ['name','slug'];

    public function accreditationRequirements()
    {
      return $this->belongsToMany('App\Regulatory\AccreditationRequirement','accr_accr-requirement','accrediation_id','accrediation-requirement_id');
    }

}
