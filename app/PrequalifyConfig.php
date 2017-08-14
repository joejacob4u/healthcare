<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrequalifyConfig extends Model
{
    protected $table = 'prequalify_config';
    
    protected $fillable = [
        'healthsystem_id',
        'input_type',
        'action_type',
        'value',
        'is_required',
        'description'
    ];
}
