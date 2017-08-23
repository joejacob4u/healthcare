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
        'name' ,'email', 'password','phone','address','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
       return $this->belongsToMany('App\Role','user_role','user_id','role_id');
    }

    public function healthSystems()
    {
      return $this->belongsToMany('App\Regulatory\HealthSystem','user_healthsystem','user_id','healthsystem_id');
    }

    public function trades()
    {
      return $this->belongsToMany('App\Trade','users-trades','user_id','trade_id');
    }
  

    public function isContractorProspect()
    {
        if(count($this->roles) == 1 && $this->roles->contains('name','Prospect'))
        {
            if(count($this->trades) > 0)
            {
                return true;
            }
        }

        return false;
    }

}
