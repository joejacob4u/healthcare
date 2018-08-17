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
}
