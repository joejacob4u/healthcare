<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class StandardLabel extends Model
{
    protected $table = 'standard_label';
    protected $fillable = ['label','text','description','accreditation_id'];

    public function accreditationRequirements()
    {
      return $this->belongsToMany('App\Regulatory\AccreditationRequirement','standard-label_accrediation-requirement','standard_label_id','accrediation_requirement_id');
    }

    public function eops()
    {
      return $this->hasMany('App\Regulatory\EOP','standard_label_id');
    }

    public function accreditation()
    {
      return $this->belongsTo('App\Regulatory\Accreditation','accreditation_id');
    }

}
