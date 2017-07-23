<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class HealthSystem extends Model
{
    protected $table = 'healthsystem';
    protected $fillable = ['healthcare_system','admin_name','admin_email','admin_phone','state'];

    public function HCOs()
    {
      return $this->hasMany('App\Admin\HCO','healthsystem_id');
    }

}
