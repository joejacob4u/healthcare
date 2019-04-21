<?php

namespace App\Assessment;

use Illuminate\Database\Eloquent\Model;
use App\Equipment\DemandWorkOrder;

class Rounding extends Model
{
    protected $table = 'assessments';

    protected $fillable = ['rounding_config_id', 'building_id', 'date', 'rounding_status_id'];

    protected $dates = ['date'];

    public function config()
    {
        return $this->belongsTo('App\Rounding\Config', 'rounding_config_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Rounding\Status', 'rounding_status_id');
    }

    public function findings()
    {
        return $this->hasMany('App\Rounding\QuestionFinding', 'rounding_id');
    }

    public function workOrders()
    {
        return $this->belongsToMany(DemandWorkOrder::class, 'rounding_question-work_order', 'rounding_id', 'work_order_id')->withPivot(['rounding_question_id']);
    }

    public function setDateAttribute($date)
    {
        return $this->attributes['date'] = \Carbon\Carbon::parse($date, session('timezone'))->setTimezone('UTC');
    }


    public function getDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date, 'UTC')->setTimezone(session('timezone'));
    }
}
