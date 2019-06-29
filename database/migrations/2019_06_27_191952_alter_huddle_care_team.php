<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHuddleCareTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('huddle_care_teams')->truncate();
        DB::table('huddle_configs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('huddle_configs', function (Blueprint $table) {
            $table->dropForeign(['leader_user_id']);
            $table->dropForeign(['alternative_leader_user_id']);
            $table->dropForeign(['recorder_of_data_user_id']);
            $table->dropForeign(['alternative_recorder_of_data_user_id']);
            $table->dropForeign(['hco_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['building_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn('leader_user_id');
            $table->dropColumn('alternative_leader_user_id');
            $table->dropColumn('recorder_of_data_user_id');
            $table->dropColumn('alternative_recorder_of_data_user_id');
            $table->dropColumn('hco_id');
            $table->dropColumn('site_id');
            $table->dropColumn('building_id');
            $table->dropColumn('department_id');
            $table->dropColumn('location');
        });


        Schema::table('huddle_care_teams', function (Blueprint $table) {
            $table->string('location')->after('healthsystem_id');
            $table->string('report_to_care_teams')->after('location')->default('{}');
            $table->unsignedInteger('leader_user_id')->after('location');
            $table->foreign('leader_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('alternative_leader_user_id')->after('leader_user_id');
            $table->foreign('alternative_leader_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('recorder_of_data_user_id')->after('alternative_leader_user_id');
            $table->foreign('recorder_of_data_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('alternative_recorder_of_data_user_id')->after('recorder_of_data_user_id');
            $table->foreign('alternative_recorder_of_data_user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('huddle_care_team-hco', function (Blueprint $table) {
            $table->unsignedInteger('huddle_care_team_id');
            $table->foreign('huddle_care_team_id')->references('id')->on('huddle_care_teams')->onDelete('cascade');
            $table->unsignedInteger('hco_id');
            $table->foreign('hco_id')->references('id')->on('hco')->onDelete('cascade');
        });

        Schema::create('huddle_care_team-site', function (Blueprint $table) {
            $table->unsignedInteger('huddle_care_team_id');
            $table->foreign('huddle_care_team_id')->references('id')->on('huddle_care_teams')->onDelete('cascade');
            $table->unsignedInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });

        Schema::create('huddle_care_team-building', function (Blueprint $table) {
            $table->unsignedInteger('huddle_care_team_id');
            $table->foreign('huddle_care_team_id')->references('id')->on('huddle_care_teams')->onDelete('cascade');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });

        Schema::create('huddle_care_team-departments', function (Blueprint $table) {
            $table->unsignedInteger('huddle_care_team_id');
            $table->foreign('huddle_care_team_id')->references('id')->on('huddle_care_teams')->onDelete('cascade');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('building_departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('huddle_care_teams', function (Blueprint $table) {
            //
        });
    }
}
