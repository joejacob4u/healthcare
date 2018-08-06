<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAssetCategoriesForRisksAndUtitlity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenance_asset_categories', function (Blueprint $table) {
            $table->unsignedInteger('maintenance_physical_risk_id')->after('id');
            $table->foreign('maintenance_physical_risk_id', 'mpr_id')->references('id')->on('maintenance_physical_risks')->onDelete('cascade');
            $table->unsignedInteger('maintenance_utility_function_id')->after('maintenance_physical_risk_id');
            $table->foreign('maintenance_utility_function_id', 'muf_id')->references('id')->on('maintenance_utility_functions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintenance_asset_categories', function (Blueprint $table) {
            //
        });
    }
}
