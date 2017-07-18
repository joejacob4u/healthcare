<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class HealthSystem extends Model
{
    protected $table = 'healthsystem';
    protected $fillable = ['healthcare_system','admin_name','admin_email','admin_phone','state'];

}
