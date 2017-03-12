<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class SubCOP extends Model
{
    protected $table = 'sub_cop';
    protected $fillable = ['cop_id','label','title','compliant'];

    public function accrTypes()
    {
      return $this->belongsToMany('App\Admin\AccrEOP','subcop_accrtypes','subcop_id','accrtype_id');
    }

    public function cop()
    {
      return $this->belongsTo('App\Admin\COP','cop_id');
    }

}
