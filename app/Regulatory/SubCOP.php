<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class SubCOP extends Model
{
    protected $table = 'sub_cop';
    protected $fillable = ['cop_id','label','title','compliant','description'];

    public function accreditationRequirements()
    {
      return $this->belongsToMany('App\Regulatory\AccreditationRequirement','accreditation-req_sub-cop','sub_cop_id','accreditation_requirement_id');
    }

    public function cop()
    {
      return $this->belongsTo('App\Regulatory\COP','cop_id');
    }

}
