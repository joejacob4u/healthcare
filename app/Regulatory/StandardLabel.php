<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class StandardLabel extends Model
{
    protected $table = 'standard_label';
    protected $fillable = ['label','text','description'];

    public function accrediationRequirements()
    {
      return $this->belongsToMany('App\Regulatory\AccrediationRequirement','standard-label_accrediation-requirement','standard_label_id','accrediation_requirement_id');
    }

    public function eops()
    {
      return $this->hasMany('App\Regulatory\EOP','standard_label_id');
    }
}
