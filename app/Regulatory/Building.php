<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'buildings';
    protected $fillable = ['name','site_id','building_id','occupancy_type','ownership','ownership_comments','accreditation_id','building_logo','building_img_dir'];

    public function site()
    {
        return $this->belongsTo('App\Regulatory\Site', 'site_id');
    }

    public function accreditations()
    {
        return $this->belongsToMany('App\Regulatory\Accreditation', 'accreditation_building', 'building_id', 'accreditation_id');
    }

    public function documents()
    {
        return $this->belongsToMany('App\Regulatory\EOPDocument', 'eop_documents-building', 'building_id', 'document_id');
    }

    public function findings()
    {
        return $this->hasMany('App\Regulatory\EOPFinding', 'building_id');
    }

    public function departments()
    {
        return $this->hasMany('App\Regulatory\BuildingDepartment', 'building_id');
    }

    public function submissionDates()
    {
        return $this->hasMany('App\Regulatory\EOPDocumentSubmissionDate', 'building_id');
    }

    public function equipments()
    {
        return $this->hasMany('App\Equipment\Equipment', 'building_id');
    }
}
