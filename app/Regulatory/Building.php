<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'buildings';
    protected $fillable = ['name','site_id','building_id','occupancy_type','square_ft','roof_sq_ft','ownership','sprinkled_pct','beds','ownership_comments','accreditation_id'];

    public function site()
    {
       return $this->belongsTo('App\Regulatory\Site','site_id');
    }
}
