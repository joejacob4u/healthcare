<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contractor extends Authenticatable
{
  protected $table = 'contractors';
  protected $fillable = ['name','email','phone','address','password','remember_token','title','corporation','partnership','sole_prop','company_owner','contract_license_number','status'];

  public function trades()
  {
    return $this->belongsToMany('App\Trade','contractor_trade','contractor_id','trade_id');
  }

  public function healthSystems()
  {
    return $this->belongsToMany('App\Regulatory\HealthSystem','contractor_healthsystem','contractor_id','healthsystem_id')
                ->withPivot('role_id', 'is_active');;
  }
}
