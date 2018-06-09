<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentsAndRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn('square_ft');
            $table->dropColumn('roof_sq_ft');
            $table->dropColumn('sprinkled_pct');
            $table->dropColumn('beds');
            $table->dropColumn('unused_space');
            $table->dropColumn('operating_rooms');
        });

        Schema::create('building_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_id');
            $table->string('name');
            $table->string('business_unit_cost_center');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_department_id');
            $table->string('room_number');
            $table->string('room_type');
            $table->boolean('is_clinical');
            $table->string('square_ft');
            $table->string('bar_code');
            $table->string('sprinkled_pct');
            $table->string('beds');
            $table->string('unused_space_sq_ft');
            $table->string('operating_rooms');
            $table->foreign('building_department_id')->references('id')->on('building_departments')->onDelete('cascade');
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
        Schema::table('buildings', function (Blueprint $table) {
            //
        });
    }
}
