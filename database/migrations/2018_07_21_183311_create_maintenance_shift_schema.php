<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceShiftSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hco_id');
            $table->foreign('hco_id')->references('id')->on('hco')->onDelete('cascade');
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        Schema::create('maintenance_shift_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('maintenance_shift_id');
            $table->foreign('maintenance_shift_id')->references('id')->on('maintenance_shifts')->onDelete('cascade');
            $table->string('description');
            $table->time('start_time');
            $table->time('end_time');
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
        Schema::dropIfExists('maintenance_shifts');
    }
}
