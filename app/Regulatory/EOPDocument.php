<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPDocument extends Model
{
    protected $table = 'eop_documents';

    protected $guarded = ['id'];

    public function buildings()
    {
        return $this->belongsToMany('App\Regulatory\Building','eop_documents-building','document_id','building_id');
    }

    public function eop()
    {
        return $this->belongsTo('App\Regulatory\EOP','eop_id');
    }

}
