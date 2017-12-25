<?php

namespace App\Workflow;

use Illuminate\Database\Eloquent\Model;

class AdministrativeLeader extends Model
{
    protected $table = 'administrative_leaders';
    protected $guarded = ['id'];
}
