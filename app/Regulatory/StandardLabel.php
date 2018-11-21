<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class StandardLabel extends Model
{
    protected $table = 'standard_label';
    protected $fillable = ['label','text','description','accreditation_requirement_id'];

    public function accreditationRequirement()
    {
        return $this->belongsTo('App\Regulatory\AccreditationRequirement', 'accreditation_requirement_id');
    }

    public function eops()
    {
        return $this->hasMany('App\Regulatory\EOP', 'standard_label_id');
    }

    public function accreditations()
    {
        return $this->belongsToMany('App\Regulatory\Accreditation', 'accreditations-standard_labels', 'standard_label_id', 'accreditation_id');
    }
}
