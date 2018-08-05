<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherMaintenanceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_frequency_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('score');
            $table->timestamps();
        });

        Schema::create('maintenance_incident_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('score');
            $table->timestamps();
        });

        Schema::create('maintenance_redundancies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('score');
            $table->timestamps();
        });

        Schema::create('maintenance_work_order_audits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('score');
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
        Schema::dropIfExists('maintenance_frequency_requirements');
    }
}
