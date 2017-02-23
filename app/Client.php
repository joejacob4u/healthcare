<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = ['name','email','phone','address'];

    public function departments()
    {
        return $this->belongsToMany('App\Department','client_department','client_id','department_id');
    }
}
