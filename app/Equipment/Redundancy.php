<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Redundancy extends Model
{
    protected $table = 'equipment_redundancies';

    protected $guarded = ['id'];
}
