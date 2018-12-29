<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreWorkOrderFieldsToEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->string('meet_current_oem_specifications')->after('utilization');
            $table->boolean('is_manufacturer_supported')->after('meet_current_oem_specifications');
            $table->boolean('is_maintenance_supported')->after('is_manufacturer_supported');
            $table->string('impact_of_device_failure')->after('is_maintenance_supported');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipments', function (Blueprint $table) {
            //
        });
    }
}
