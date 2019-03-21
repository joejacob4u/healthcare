<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundingConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounding_configs', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');

            $table->unsignedInteger('building_department_id');
            $table->foreign('building_department_id')->references('id')->on('building_departments')->onDelete('cascade');

            $table->unsignedInteger('rounding_checklist_type_id');
            $table->foreign('rounding_checklist_type_id', 'rct_id')->references('id')->on('rounding_checklist_types')->onDelete('cascade');

            $table->string('frequency');
            $table->string('baseline_date');

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
        Schema::table('rounding_configs', function (Blueprint $table) {
            //
        });
    }
}
