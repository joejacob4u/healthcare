<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class IlsmChecklistQuestion extends Model
{
    protected $table = 'ilsm_checklist_questions';

    protected $fillable = ['question'];

    public function ilsm()
    {
        return $this->belongsTo('App\Equipment\Ilsm', 'ilsm_id');
    }
}
