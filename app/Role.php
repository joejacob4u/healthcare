<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name','permissions'];

    protected $casts = ['permissions' => 'array'];

    public $timestamps = false;

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions);
    }
}
