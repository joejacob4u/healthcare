<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Ilsm extends Model
{
    protected $table = 'ilsms';

    protected $fillable = ['label','description'];

    public function questions()
    {
        return $this->belongsToMany('App\Equipment\IlsmQuestion', 'ilsm-ilsm_question', 'ilsm_id');
    }
}
