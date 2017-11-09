<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
  protected $table = 'contractors';
  protected $fillable = ['name','email','phone','address','password','remember_token','corporation','partnership','sole_prop','company_owner','contract_license_number','status'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

}
