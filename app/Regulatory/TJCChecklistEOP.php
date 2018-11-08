<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class TJCChecklistEOP extends Model
{
    protected $table = 'tjc_checklist_eops';

    protected $guarded = ['id'];


    public function eop()
    {
        return $this->belongsTo('App\Regulatory\EOP', 'eop_id');
    }

    public function tjcChecklists()
    {
        return $this->hasMany('App\Regulatory\TJCChecklistEOP', 'tjc_checklist_eop_id');
    }

    public function tjcChecklistStatuses()
    {
        return $this->hasMany('App\Regulatory\TJCChecklistStatus', 'tjc_checklist_eop_id');
    }
}
