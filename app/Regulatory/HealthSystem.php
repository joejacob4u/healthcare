<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class HealthSystem extends Model
{
    protected $table = 'healthsystem';
    protected $fillable = ['healthcare_system','admin_name','admin_email','admin_phone','state','healthsystem_logo'];

    public function HCOs()
    {
      return $this->hasMany('App\Regulatory\HCO','healthsystem_id');
    }

    public function users()
    {
      return $this->belongsToMany('App\User','user_healthsystem','healthsystem_id','user_id');
    }

    public function prequalifyConfigs()
    {
      return $this->hasMany('App\PrequalifyConfig','healthsystem_id');
    }


}
