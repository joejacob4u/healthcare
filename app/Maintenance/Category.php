<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'maintenance_categories';

    protected $guarded = ['id'];

    public function assetCategories()
    {
        return $this->hasMany('App\Maintenance\AssetCategory', 'maintenance_category_id');
    }
}
