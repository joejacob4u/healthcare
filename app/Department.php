<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public function clients()
    {
      return $this->belongsToMany('App\Client','client_department','department_id','client_id');
    }
}
