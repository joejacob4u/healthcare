<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class COP extends Model
{
    protected $table = 'cop';
    protected $fillable = ['label','title','compliant'];

    public function subCOPs()
    {
      return $this->hasMany('App\Admin\SubCOP','cop_id');
    }

}
