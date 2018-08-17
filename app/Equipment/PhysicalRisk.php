<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class PhysicalRisk extends Model
{
    protected $table = 'equipment_physical_risks';

    protected $guarded = ['id'];
}
