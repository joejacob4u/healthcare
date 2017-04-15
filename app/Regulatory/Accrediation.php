<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Accrediation extends Model
{
    protected $table = 'accrediation';
    protected $fillable = ['name','slug'];

    public function subCOPs()
    {
      return $this->belongsToMany('App\Regulatory\SubCOP','accrediation_sub-cop','accrediation_id','sub_cop_id');
    }

}
