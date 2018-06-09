<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class BuildingDepartment extends Model
{
    protected $table = 'building_departments';

    protected $guarded = ['id'];

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    /**
     * rooms
     *
     * @return void
     */
    public function rooms()
    {
        return $this->hasMany('App\Regulatory\Room', 'building_department_id');
    }
}
