<?php

namespace App\Biomed;

use Illuminate\Database\Eloquent\Model;

class CurrentState extends Model
{
    protected $table = 'biomed_current_states';

    protected $guarded = ['id'];
}
