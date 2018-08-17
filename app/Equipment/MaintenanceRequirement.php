<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequirement extends Model
{
    protected $table = 'equipment_maintenance_requirements';

    protected $guarded = ['id'];
}
