<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class UtilityFunction extends Model
{
    protected $table = 'maintenance_utility_functions';

    protected $guarded = ['id'];
}
