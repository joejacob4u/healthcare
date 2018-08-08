<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class IncidentHistory extends Model
{
    protected $table = 'maintenance_incident_histories';

    protected $guarded = ['id'];
}
