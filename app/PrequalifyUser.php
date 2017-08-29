<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrequalifyUser extends Model
{
    protected $table = 'prequalify_users';
    protected $fillable = ['user_id','healthsystem_id','status'];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function healthSystem()
    {
        return $this->hasOne('App\Regulatory\HealthSystem','id','healthsystem_id');
    }
}
