<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class IncidentHistory extends Model
{
    protected $table = 'utility_incident_histories';

    protected $guarded = ['id'];
}
