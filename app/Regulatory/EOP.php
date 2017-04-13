<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOP extends Model
{
    protected $table = 'eop';
    protected $fillable = ['name','standard_label_id','documentation','frequency','risk','risk_assessment','text'];

    public function standardLabel()
    {
      return $this->belongsTo('App\Regulatory\StandardLabel','standard_label_id','id');
    }
}
