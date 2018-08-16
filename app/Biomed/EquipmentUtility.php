<?php

namespace App\Biomed;

use Illuminate\Database\Eloquent\Model;

class EquipmentUtility extends Model
{
    protected $table = 'biomed_equipment_utilizations';

    protected $guarded = ['id'];
}
