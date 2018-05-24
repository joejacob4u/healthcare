<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class TJCChecklistEOP extends Model
{
    protected $table = 'tjc_checklist_eops';

    protected $guarded = ['id'];

    /**
     * tjc_checklist_standard - returns standard of a given tjc eop
     *
     * @return collection
     */
    public function tjc_checklist_standard()
    {
        return $this->belongsTo('App\Regulatory\TJCChecklistStandard', 'tjc_checklist_standard_id');
    }

    public function eop()
    {
        return $this->belongsTo('App\Regulatory\EOP', 'eop_id');
    }
}
