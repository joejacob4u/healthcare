<?php

namespace App\Rounding;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'rounding_configs';

    protected $guarded = ['id'];

    protected $dates = ['baseline_date'];

    public function checklistType()
    {
        return $this->belongsTo('App\Rounding\ChecklistType', 'rounding_checklist_type_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Regulatory\BuildingDepartment', 'building_department_id');
    }
}
