<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class DrawingCategory extends Model
{
    protected $table = 'facility_maintenance_drawing_categories';

    protected $fillable = ['name'];

    public function drawings()
    {
        return $this->hasMany('App\Equipment\Drawing', 'facility_maintenance_drawing_category_id');
    }
}
