<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOP extends Model
{
    protected $table = 'eop';
    protected $fillable = ['name','standard_label_id','documentation','frequency','risk','risk_assessment','text','occupancy_type'];

    public function standardLabel()
    {
      return $this->belongsTo('App\Regulatory\StandardLabel','standard_label_id','id');
    }

    public function subCOPs()
    {
      return $this->belongsToMany('App\Regulatory\SubCOP','eop_sub-cop','eop_id','sub_cop_id');
    }

}
