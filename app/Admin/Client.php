<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = ['name','email','phone','address'];

    public function departments()
    {
        return $this->belongsToMany('App\Admin\Department','client_department','client_id','department_id');
    }

}
