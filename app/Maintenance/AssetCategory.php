<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $table = 'maintenance_asset_categories';

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('App\Maintenance\Category', 'maintenance_category_id');
    }
}
