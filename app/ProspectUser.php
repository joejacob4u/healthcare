<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProspectUser extends Model
{
  protected $table = 'prospect_users';
  protected $fillable = ['user_id','corporation','partnership','sole_prop','company_owner','contract_license_number','status'];

}
