<?php

namespace App\Huddle;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Huddle extends Model
{
    protected $table = 'huddles';

    protected $guarded = ['id'];

    protected $dates = ['date'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'huddle_attendance', 'huddle_id', 'user_id');
    }

    public function recorderOfData()
    {
        return $this->belongsTo(User::class, 'recorder_of_data_user_id');
    }

    public function careTeam()
    {
        return $this->belongsTo(CareTeam::class, 'care_team_id');
    }
}
