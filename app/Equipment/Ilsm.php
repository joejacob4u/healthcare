<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Ilsm extends Model
{
    protected $table = 'ilsms';

    protected $fillable = ['label','description','frequency','attachment_required'];

    public function questions()
    {
        return $this->belongsToMany('App\Equipment\IlsmQuestion', 'ilsm-ilsm_question', 'ilsm_id');
    }

    public function ilsmChecklistQuestions()
    {
        return $this->hasMany('App\Equipment\IlsmChecklistQuestion', 'ilsm_id');
    }
}
