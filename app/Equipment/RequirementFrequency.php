<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class RequirementFrequency extends Model
{
    protected $table = 'equipment_requirement_frequencies';

    protected $guarded = ['id'];
}
