<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class TJCChecklist extends Model
{
    protected $table = 'tjc_checklists';

    protected $guarded = ['id'];

    public function tjcChecklistEOP()
    {
        return $this->belongsTo('App\Regulatory\TJCChecklistEOP', 'tjc_checklist_eop_id');
    }

    public function tjcChecklistStatuses()
    {
        return $this->hasMany('App\Regulatory\TJCChecklistStatus', 'tjc_checklist_id');
    }
}
