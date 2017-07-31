<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  protected $table = 'sites';
  protected $fillable = ['name','site_id','address'];

  public function buildings()
  {
    return $this->hasMany('App\Regulatory\Building','site_id');
  }

  public function hco()
  {
    return $this->belongsTo('App\Regulatory\HCO','hco_id');
  }


}
