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

    public function tjcChecklistStatusStatusesSnapshot()
    {
        $progress_count['not_set'] = 0;
        $progress_count['c'] = 0;
        $progress_count['nc'] = 0;
        $progress_count['na'] = 0;
        $progress_count['iou'] = 0;

        foreach ($this->tjcChecklistStatuses as $tjc_checklist_status) {
            if ($tjc_checklist_status->status == 'n/a') {
                $progress_count['na']++;
            } elseif (empty($tjc_checklist_status->status)) {
                $progress_count['not_set']++;
            } else {
                $progress_count[$tjc_checklist_status->status]++;
            }
        }

        return $progress_count;
    }
}
