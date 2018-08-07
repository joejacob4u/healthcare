<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class RequirementFrequency extends Model
{
    protected $table = 'maintenance_frequency_requirements';

    protected $guarded = ['id'];
}
