<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Ilsm extends Model
{
    protected $table = 'ilsms';

    protected $fillable = ['label','description'];

    public function checklists()
    {
        return $this->hasMany('App\Equipment\IlsmChecklist', 'ilsm_id');
    }
}
