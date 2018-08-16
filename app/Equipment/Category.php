<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'utility_categories';

    protected $guarded = ['id'];

    public function assetCategories()
    {
        return $this->hasMany('App\Equipment\AssetCategory', 'utility_category_id');
    }
}
