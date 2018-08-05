<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableForMaintenanceAssetCategoryToEop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_asset_category_to_eop', function (Blueprint $table) {
            $table->unsignedInteger('maintenance_asset_category_id');
            $table->foreign('maintenance_asset_category_id', 'mc_id')->references('id')->on('maintenance_asset_categories')->onDelete('cascade');
            $table->unsignedInteger('eop_id');
            $table->foreign('eop_id')->references('id')->on('eop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_asset_category_to_eop');
    }
}
