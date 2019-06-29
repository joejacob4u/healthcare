<?php

namespace App\Huddle;

use Illuminate\Database\Eloquent\Model;
use App\Regulatory\HCO;
use App\Regulatory\Site;
use App\Regulatory\Building;
use App\Regulatory\BuildingDepartment;

class CareTeam extends Model
{
    protected $table = 'huddle_care_teams';

    protected $fillable = ['name', 'tier_id', 'healthsystem_id', 'location', 'leader_user_id', 'alternative_leader_user_id', 'recorder_of_data_user_id', 'alternative_recorder_of_data_user_id', 'report_to_care_teams'];

    protected $casts = ['report_to_care_teams' => 'array'];

    public function configs()
    {
        return $this->hasMany(Config::class, 'care_team_id');
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
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

    public function hcos()
    {
        return $this->belongsToMany(HCO::class, 'huddle_care_team-hco', 'huddle_care_team_id', 'hco_id');
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'huddle_care_team-site', 'huddle_care_team_id', 'site_id');
    }

    public function buildings()
    {
        return $this->belongsToMany(Building::class, 'huddle_care_team-building', 'huddle_care_team_id', 'building_id');
    }

    public function departments()
    {
        return $this->belongsToMany(BuildingDepartment::class, 'huddle_care_team-departments', 'huddle_care_team_id', 'department_id');
    }
}
