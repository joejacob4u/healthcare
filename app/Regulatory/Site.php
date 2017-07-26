<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  protected $table = 'sites';
  protected $fillable = ['name','site_id','state','address','city','zip'];

}
