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

    public function hco()
    {
        return $this->belongsTo(HCO::class, 'hco_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function department()
    {
        return $this->belongsTo(BuildingDepartment::class, 'department_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'huddle_tier_id');
    }

    public function leader()
    {
        return $this->belongsTo(App\User::class, 'leader_user_id');
    }

    public function alternativeLeader()
    {
        return $this->belongsTo(App\User::class, 'alternative_leader_user_id');
    }

    public function recorderOfData()
    {
        return $this->belongsTo(App\User::class, 'recorder_of_data_user_id');
    }

    public function alternativeRecorderOfData()
    {
        return $this->belongsTo(App\User::class, 'alternative_recorder_of_data_user_id');
    }
}
