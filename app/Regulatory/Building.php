<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'buildings';
    protected $fillable = ['name','site_id','building_id','occupancy_type','square_ft'];

    public function site()
    {
       return $this->belongsTo('App\Regulatory\Site','site_id');
    }
}
