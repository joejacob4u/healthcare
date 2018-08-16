<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Redundancy extends Model
{
    protected $table = 'utility_redundancies';

    protected $guarded = ['id'];
}
