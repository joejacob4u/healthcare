<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class HCO extends Model
{
  protected $table = 'hco';
  protected $fillable = ['facility_name','address','hco_id','healthsystem_id'];

  public function healthcareSystem()
  {
    return $this->belongsTo('App\Admin\HealthSystem','healthsystem_id');
  }

}
