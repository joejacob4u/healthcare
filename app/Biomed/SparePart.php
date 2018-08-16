<?php

namespace App\Biomed;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $table = 'biomed_spare_parts';

    protected $guarded = ['id'];
}
