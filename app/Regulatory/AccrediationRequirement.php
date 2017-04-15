<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class AccrediationRequirement extends Model
{
    protected $table = 'accrediation_requirements';
    protected $fillable = ['name'];

    public function accrediations()
    {
      return $this->belongsToMany('App\Regulatory\Accrediation','accr_accr-requirement','accrediation-requirement_id','accrediation_id');
    }

}
