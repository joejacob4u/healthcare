<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $table = 'utility_asset_categories';

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('App\Equipment\Category', 'utility_category_id');
    }

    public function eops()
    {
        return $this->belongsToMany('App\Regulatory\EOP', 'utility_asset_category_to_eop', 'utility_asset_category_id', 'eop_id');
    }
}
