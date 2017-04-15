<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class SubCOP extends Model
{
    protected $table = 'sub_cop';
    protected $fillable = ['cop_id','label','title','compliant'];

    public function accrediationRequirements()
    {
      return $this->belongsToMany('App\Regulatory\AccrediationRequirement','accrediation-req_sub-cop','sub_cop_id','accrediation_requirement_id');
    }

    public function cop()
    {
      return $this->belongsTo('App\Regulatory\COP','cop_id');
    }

}
