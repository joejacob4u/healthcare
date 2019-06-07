<?php

namespace App\Huddle;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    protected $table = 'huddle_tiers';

    public function configs()
    {
        return $this->hasMany(Config::class, 'huddle_tier_id');
    }
}
