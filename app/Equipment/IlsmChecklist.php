<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class IlsmChecklist extends Model
{
    protected $table = 'ilsm_checklists';

    protected $fillable = ['question'];

    public function ilsm()
    {
        return $this->belongsTo('App\Equipment\Ilsm', 'ilsm_id');
    }
}
