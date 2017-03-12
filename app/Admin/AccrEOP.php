<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class AccrEOP extends Model
{
    protected $table = 'accreditation_eop';
    protected $fillable = ['elements_of_performance','accr_req_id','documentation',
                            'frequency','risk','risk_assessment'];

    public function accrRequirement()
    {
      return $this->belongsTo('App\Admin\AccrRequirement','accr_req_id');
    }

    public function referenceEops()
    {
      return $this->belongsToMany('App\Admin\AccrEOP','eop_id-eop_reference_id','eop_reference_id','eop_id');
    }
}
