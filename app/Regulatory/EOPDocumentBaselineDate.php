<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPDocumentBaselineDate extends Model
{
    protected $table = 'documentation_baseline_dates';

    protected $fillable = ['eop_id','building_id','baseline_date','is_baseline_disabled','comment'];

    public $timestamps = false;


}
