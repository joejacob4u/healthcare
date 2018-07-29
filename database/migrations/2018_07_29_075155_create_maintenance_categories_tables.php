<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('maintenance_asset_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('service_life');
            $table->timestamps();
        });

        Schema::create('maintenance_utility_functions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('score');
            $table->timestamps();
        });

        Schema::create('maintenance_physical_risks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('score');
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
        Schema::dropIfExists('maintenance_category');
    }
}
