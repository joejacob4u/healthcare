<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $table = 'equipment_asset_categories';

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('App\Equipment\Category', 'equipment_category_id');
    }

    public function eops()
    {
        return $this->belongsToMany('App\Regulatory\EOP', 'equipment_asset_category_to_eop', 'equipment_asset_category_id', 'eop_id');
    }

    public function physicalRisk()
    {
        return $this->belongsTo('App\Equipment\PhysicalRisk', 'equipment_physical_risk_id');
    }

    public function utilityFunction()
    {
        return $this->belongsTo('App\Equipment\UtilityFunction', 'equipment_utility_function_id');
    }

    public function systemTier()
    {
        return $this->belongsTo('App\SystemTier', 'system_tier_id');
    }
}
