<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccrRequirement extends Model
{
    protected $table = 'accr_requirements';
    protected $fillable = ['label','text','department_id'];

    public function department()
    {
      return $this->belongsTo('App\Department','department_id');
    }

    public function eops()
    {
      return $this->hasMany('App\AccrEOP','accr_req_id');
    }
}
