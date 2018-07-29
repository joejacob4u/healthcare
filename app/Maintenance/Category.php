<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'maintenance_categories';

    protected $guarded = ['id'];
}
