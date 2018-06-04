<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class TJCChecklistStatus extends Model
{
    protected $table = 'tjc_checklist_status';

    protected $guarded = ['id'];

    public function tjcChecklist()
    {
        return $this->belongsTo('App\Regulatory\TJCChecklist', 'tjc_checklist_id');
    }

    public function tjcChecklistEOP()
    {
        return $this->belongsTo('App\Regulatory\TJCChecklistEOP', 'tjc_checklist_eop_id');
    }
}
