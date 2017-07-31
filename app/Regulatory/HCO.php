<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class HCO extends Model
{
  protected $table = 'hco';
  protected $fillable = ['facility_name','address','hco_id','healthsystem_id'];

  public function healthcareSystem()
  {
    return $this->belongsTo('App\Regulatory\HealthSystem','healthsystem_id');
  }

  public function sites()
  {
    return $this->hasMany('App\Regulatory\Site','hco_id');
  }


}
