<?php

namespace App\Biomed;

use Illuminate\Database\Eloquent\Model;

class EquipmentUser extends Model
{
    protected $table = 'biomed_equipment_users';

    protected $guarded = ['id'];
}
