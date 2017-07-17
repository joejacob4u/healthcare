<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = ['healthcare_system','facility_name','address','hco_id','admin_name','admin_email','admin_phone','state'];

}
