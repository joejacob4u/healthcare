<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemTier extends Model
{
    protected $table = 'system_tiers';

    protected $guarded = ['id'];

    public function workOrderQuestionnaires()
    {
        return $this->hasMany('App\WorkOrder\WorkOrderQuestionnaire', 'system_tier_id');
    }

    public function assetCategories()
    {
        return $this->hasMany('App\Equipment\AssetCategory', 'system_tier_id');
    }

    public function trades()
    {
        return $this->hasMany('App\Equipment\Trade', 'system_tier_id');
    }
}
