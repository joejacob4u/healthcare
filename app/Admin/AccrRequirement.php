<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class AccrRequirement extends Model
{
    protected $table = 'accr_requirements';
    protected $fillable = ['label','text','department_id'];

    public function department()
    {
      return $this->belongsTo('App\Admin\Department','department_id');
    }

    public function eops()
    {
      return $this->hasMany('App\Admin\AccrEOP','accr_req_id');
    }
}
