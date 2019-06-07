<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHuddleConfigSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huddle_tiers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('huddle_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('healthsystem_id');
            $table->foreign('healthsystem_id')->references('id')->on('healthsystem')->onDelete('cascade');
            $table->unsignedInteger('hco_id');
            $table->foreign('hco_id')->references('id')->on('hco')->onDelete('cascade');
            $table->unsignedInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('building_departments')->onDelete('cascade');
            $table->unsignedInteger('huddle_tier_id');
            $table->foreign('huddle_tier_id')->references('id')->on('huddle_tiers')->onDelete('cascade');
            $table->string('schedule');
            $table->string('time');
            $table->unsignedInteger('leader_user_id');
            $table->foreign('leader_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('alternative_leader_user_id');
            $table->foreign('alternative_leader_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('recorder_of_data_user_id');
            $table->foreign('recorder_of_data_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('alternative_recorder_of_data_user_id');
            $table->foreign('alternative_recorder_of_data_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('huddle_configs');
    }
}
