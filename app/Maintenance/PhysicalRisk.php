<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class PhysicalRisk extends Model
{
    protected $table = 'maintenance_physical_risks';

    protected $guarded = ['id'];
}
