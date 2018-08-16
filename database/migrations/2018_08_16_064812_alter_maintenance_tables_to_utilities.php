<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMaintenanceTablesToUtilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('maintenance_asset_categories', function (Blueprint $table) {
            $table->renameColumn('maintenance_physical_risk_id', 'utility_physical_risk_id');
            $table->renameColumn('maintenance_utility_function_id', 'utility_utility_function_id');
            $table->dropForeign(['maintenance_category_id']);
        });

        Schema::rename('maintenance_asset_categories', 'utility_asset_categories');

        Schema::rename('maintenance_asset_category_to_eop', 'utility_asset_category_to_eop');
        Schema::rename('maintenance_categories', 'utility_categories');
        Schema::rename('maintenance_frequency_requirements', 'utility_frequency_requirements');
        Schema::rename('maintenance_incident_histories', 'utility_incident_histories');
        Schema::rename('maintenance_physical_risks', 'utility_physical_risks');
        Schema::rename('maintenance_utility_functions', 'utility_utility_functions');

        Schema::table('utility_asset_categories', function (Blueprint $table) {
            $table->renameColumn('maintenance_category_id', 'utility_category_id');
            $table->foreign('utility_category_id')->references('id')->on('utility_categories')->onDelete('cascade');
        });


        Schema::table('utility_asset_category_to_eop', function (Blueprint $table) {
            $table->dropForeign('mc_id');
            $table->renameColumn('maintenance_asset_category_id', 'utility_asset_category_id');
            $table->foreign('utility_asset_category_id', 'uac_id')->references('id')->on('utility_asset_categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
