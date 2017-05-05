<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class COP extends Model
{
    protected $table = 'cop';
    protected $fillable = ['label','title'];

    public function subCOPs()
    {
      return $this->hasMany('App\Admin\SubCOP','cop_id');
    }

}
