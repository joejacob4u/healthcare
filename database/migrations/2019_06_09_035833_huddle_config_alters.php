<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HuddleConfigAlters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('huddle_care_teams');

        Schema::create('huddle_care_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('tier_id');
            $table->foreign('tier_id')->references('id')->on('huddle_tiers')->onDelete('cascade');
            $table->unsignedInteger('healthsystem_id');
            $table->foreign('healthsystem_id')->references('id')->on('healthsystem')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('huddle_configs', function (Blueprint $table) {
            $table->string('location')->after('time');
            $table->dropColumn('name');
            $table->dropForeign(['huddle_tier_id']);
            $table->dropColumn('huddle_tier_id');
            $table->unsignedInteger('care_team_id')->after('id');
            $table->foreign('care_team_id')->references('id')->on('huddle_care_teams')->onDelete('cascade');
        });

        Schema::create('huddle_config-huddle_care_team', function (Blueprint $table) {
            $table->unsignedInteger('config_id');
            $table->foreign('config_id')->references('id')->on('huddle_configs')->onDelete('cascade');
            $table->unsignedInteger('care_team_id');
            $table->foreign('care_team_id')->references('id')->on('huddle_care_teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('huddle_configs', function (Blueprint $table) {
            //
        });
    }
}
