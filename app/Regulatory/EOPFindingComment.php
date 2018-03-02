<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPFindingComment extends Model
{
    protected $table = 'eop_finding_comments';
    protected $guarded = ['id'];

    public function finding()
    {
        return $this->belongsTo('App\Regulatory\EOPFinding','eop_finding_id');
    }
}
