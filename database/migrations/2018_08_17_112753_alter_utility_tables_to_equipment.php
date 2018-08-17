<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUtilityTablesToEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::rename('utility_asset_categories', 'equipment_asset_categories');
        Schema::rename('utility_categories', 'equipment_categories');

        Schema::table('equipment_asset_categories', function (Blueprint $table) {
            $table->renameColumn('utility_physical_risk_id', 'equipment_physical_risk_id');
            $table->renameColumn('utility_utility_function_id', 'equipment_utility_function_id');
            //$table->dropForeign('utility_asset_categories_utility_category_id_foreign');
            $table->renameColumn('utility_category_id', 'equipment_category_id');
            $table->foreign('equipment_category_id')->references('id')->on('equipment_categories')->onDelete('cascade');
        });


        Schema::rename('utility_asset_category_to_eop', 'equipment_asset_category_to_eop');
        
        Schema::rename('utility_frequency_requirements', 'equipment_frequency_requirements');
        Schema::rename('utility_incident_histories', 'equipment_incident_histories');
        Schema::rename('utility_physical_risks', 'equipment_physical_risks');
        Schema::rename('utility_utility_functions', 'equipment_utility_functions');



        Schema::table('equipment_asset_category_to_eop', function (Blueprint $table) {
            $table->dropForeign('uac_id');
            $table->renameColumn('utility_asset_category_id', 'equipment_asset_category_id');
            $table->foreign('equipment_asset_category_id', 'uac_id')->references('id')->on('equipment_asset_categories')->onDelete('cascade');
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
