<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use DB;

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
      return $this->hasMany('App\User','healthsystem_id');
    }

    public function prequalifyConfigs()
    {
      return $this->hasMany('App\PrequalifyConfig','healthsystem_id');
    }

    public function contractors()
    {
      return $this->belongsToMany('App\Contractors','contractor_healthsystem','healthsystem_id','contractor_id');
    }

    public function contractorType($type)
    {
      return collect(DB::select("select contractors.id,contractors.name from contractors 
                        left join contractor_healthsystem on contractor_healthsystem.`contractor_id` = contractors.id
                        left join contractor_trade on contractor_trade.`contractor_id` = contractors.id
                        left join trades on trades.`id` = contractor_trade.`trade_id`
                        where trades.`name` = '".$type."' and contractor_healthsystem.`is_active` = 1 and contractor_healthsystem.healthsystem_id ='".$this->id."'"));
    }


}
