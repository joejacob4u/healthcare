<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Accrediation extends Model
{
    protected $table = 'accrediation';
    protected $fillable = ['name','slug'];
}
