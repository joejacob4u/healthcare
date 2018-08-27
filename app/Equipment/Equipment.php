<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $guarded = ['id'];

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Regulatory\Room', 'room_id');
    }
}
