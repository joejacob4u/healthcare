<?php

namespace App\WorkOrder;

use Illuminate\Database\Eloquent\Model;

class Assignee extends Model
{
    protected $table = 'wo_assignees';
    protected $fillable = ['name','email'];
}
