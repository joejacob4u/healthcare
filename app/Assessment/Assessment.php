<?php

namespace App\Assessment;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = 'assessments';

    protected $guarded = ['id'];
}
