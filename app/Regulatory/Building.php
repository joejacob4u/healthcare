<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'buildings';
    protected $fillable = ['name','site_id','building_id','occupancy_type','square_ft','roof_sq_ft','ownership','sprinkled_pct','beds','ownership_comments','accreditation_id','operating_rooms','unused_space','building_logo','building_img_dir'];

    public function site()
    {
       return $this->belongsTo('App\Regulatory\Site','site_id');
    }

    public function accreditations()
    {
        return $this->belongsToMany('App\Regulatory\Accreditation','accreditation_building','building_id','accreditation_id');
    }

    public function eopDocumentations()
    {
        return $this->belongsToMany('App\Regulatory\EOP','eop_documentation','building_id','eop_id')->withPivot('accreditation_id', 'document_path','submission_date','user_id');
    }
}
