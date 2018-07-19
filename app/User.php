<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' ,'email', 'password','phone','address','status','forgot_password','role_id','healthsystem_id','is_verifier'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function healthSystem()
    {
        return $this->belongsTo('App\Regulatory\HealthSystem', 'healthsystem_id');
    }


    public function departments()
    {
        return $this->belongsToMany('App\Department', 'user_department', 'user_id', 'department_id');
    }

    public function isAdmin()
    {
        return (in_array($this->role_id, [2,3])) ? 1 : 0;
    }

    public function isVerifier()
    {
        return $this->is_verifier;
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Regulatory\Building', 'user_building', 'user_id', 'building_id');
    }

    public function isActive()
    {
        if ($this->status == 'active') {
            return true;
        } else {
            return false;
        }
    }
}
