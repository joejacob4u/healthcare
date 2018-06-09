<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $guarded = ['id'];

    public function buildingDepartment()
    {
        return $this->belongsTo('App\Regulatory\BuildingDepartment', 'building_department_id');
    }
}
