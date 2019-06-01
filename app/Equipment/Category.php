<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'equipment_categories';

    protected $guarded = ['id'];

    public function assetCategories()
    {
        return $this->hasMany('App\Equipment\AssetCategory', 'equipment_category_id');
    }

    public function equipments()
    {
        return $this->hasMany('App\Equipment\Equipment', 'equipment_category_id');
    }
}
