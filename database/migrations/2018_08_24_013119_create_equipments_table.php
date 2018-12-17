<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->string('name');
            $table->unsignedInteger('equipment_category_id');
            $table->foreign('equipment_category_id')->on('equipment_categories')->references('id')->onDelete('cascade');
            $table->unsignedInteger('equipment_asset_category_id');
            $table->foreign('equipment_asset_category_id', 'eac_id')->on('equipment_asset_categories')->references('id')->onDelete('cascade');
            $table->string('description');
            $table->unsignedInteger('equipment_frequency_requirement_id');
            $table->foreign('equipment_frequency_requirement_id', 'effr_id')->on('equipment_frequency_requirements')->references('id')->onDelete('cascade');
            $table->string('manufacturer');
            $table->string('model_number');
            $table->string('serial_number');
            $table->string('manufacturer_date');
            $table->string('estimated_replacement_cost');
            $table->string('estimated_deferred_maintenance_cost');
            $table->string('identification_number');
            $table->string('department_id');
            $table->string('room_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
