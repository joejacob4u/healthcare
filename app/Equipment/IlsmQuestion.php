<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class IlsmQuestion extends Model
{
    protected $table = 'ilsm_questions';

    protected $fillable = ['question'];

    public function ilsms()
    {
        return $this->belongsToMany('App\Equipment\Ilsm', 'ilsm-ilsm_question', 'ilsm_question_id', 'ilsm_id');
    }
}
