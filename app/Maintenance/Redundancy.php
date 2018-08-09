<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Redundancy extends Model
{
    protected $table = 'maintenance_redundancies';

    protected $guarded = ['id'];
}
