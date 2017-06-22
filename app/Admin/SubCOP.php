<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class SubCOP extends Model
{
    protected $table = 'sub_cop';
    protected $fillable = ['cop_id','label','title','compliant','description'];

    public function accrTypes()
    {
      return $this->belongsToMany('App\Admin\AccrType','subcop_accrtype','subcop_id','accrtype_id');
    }

    public function cop()
    {
      return $this->belongsTo('App\Admin\COP','cop_id');
    }

}
