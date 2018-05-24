<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class TJCChecklistStandard extends Model
{
    protected $table = 'tjc_checklist_standards';

    protected $guarded = ['id'];

    /**
     * tjc_checklist_eops - return all eops under this standard
     *
     * @return collection
     */
    public function tjc_checklist_eops()
    {
        return $this->hasMany('App\Regulatory\TJCChecklistEOP', 'tjc_checklist_standard_id');
    }

    public function standardLabel()
    {
        return $this->belongsTo('App\Regulatory\StandardLabel', 'standard_label_id');
    }
}
