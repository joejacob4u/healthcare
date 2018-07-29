<?php

namespace App\Maintenance;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $table = 'maintenance_asset_categories';

    protected $guarded = ['id'];
}
