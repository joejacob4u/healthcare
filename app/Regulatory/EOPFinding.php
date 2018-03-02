<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPFinding extends Model
{
    protected $table = 'eop_findings';
    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany('App\Regulatory\EOPFindingComment','eop_finding_id');
    }
}
