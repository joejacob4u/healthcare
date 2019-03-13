<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    protected $table = 'facility_maintenance_drawings';

    protected $guarded = ['id'];

    protected $dates = ['date'];

    public function category()
    {
        return $this->belongsTo('App\Equipment\DrawingCategory', 'facility_maintenance_drawing_category_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
