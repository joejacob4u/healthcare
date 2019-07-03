<?php

namespace App\Huddle;

use Illuminate\Database\Eloquent\Model;
use App\Regulatory\HCO;
use App\Regulatory\Site;
use App\Regulatory\Building;
use App\Regulatory\BuildingDepartment;

class Config extends Model
{
    protected $table = 'huddle_configs';

    protected $guarded = ['id'];

    protected $casts = ['schedule' => 'array'];

    public function careTeam()
    {
        return $this->belongsTo(CareTeam::class, 'care_team_id');
    }
}
