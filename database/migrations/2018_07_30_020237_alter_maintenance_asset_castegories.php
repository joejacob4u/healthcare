<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMaintenanceAssetCastegories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenance_asset_categories', function (Blueprint $table) {
            $table->unsignedInteger('maintenance_category_id')->after('id');
            $table->foreign('maintenance_category_id')->references('id')->on('maintenance_categories')->onDelete('cascade');
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
