<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDrawingSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_maintenance_drawing_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('facility_maintenance_drawings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->unsignedInteger('facility_maintenance_drawing_category_id');
            $table->foreign('facility_maintenance_drawing_category_id', 'fmdc_id')->references('id')->on('facility_maintenance_drawing_categories')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('date');
            $table->unsignedInteger('user_id');
            $table->string('attachment_dir');
            $table->timestamps();
        });

        DB::table('facility_maintenance_drawing_categories')->insert([
            ['name' => 'Life Safety Drawings'],
            ['name' => 'Electrical Drawings'],
            ['name' => 'Domestic Water System Drawings'],
            ['name' => 'Hydronic System Drawings'],
            ['name' => 'Waste Water Drawings'],
            ['name' => 'Mechanical Drawings']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilty_maintenance_drawing_categories');
    }
}
