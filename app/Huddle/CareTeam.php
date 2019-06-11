<?php

namespace App\Huddle;

use Illuminate\Database\Eloquent\Model;

class CareTeam extends Model
{
    protected $table = 'huddle_care_teams';

    protected $guarded = ['id'];

    public function configs()
    {
        return $this->hasMany(Config::class, 'care_team_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }
}
