<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class RequirementFrequency extends Model
{
    protected $table = 'utility_frequency_requirements';

    protected $guarded = ['id'];
}
