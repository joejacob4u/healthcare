<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class AccrType extends Model
{
    protected $table = 'accr_types';
    protected $fillable = ['name','slug'];

    public function subCOPs()
    {
      return $this->belongsToMany('App\Admin\SubCOP','subcop_accrtype','accrtype_id','subcop_id');
    }
}
