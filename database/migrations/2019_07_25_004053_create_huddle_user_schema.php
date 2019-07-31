<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHuddleUserSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huddles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('healthsystem_id');
            $table->foreign('healthsystem_id')->references('id')->on('healthsystem')->onDelete('cascade');
            $table->unsignedInteger('care_team_id');
            $table->foreign('care_team_id')->references('id')->on('huddle_care_teams')->onDelete('cascade');
            $table->unsignedInteger('recorder_of_data_user_id');
            $table->foreign('recorder_of_data_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('date');
            $table->string('no_of_available_beds');
            $table->string('no_of_occupied_beds');
            $table->string('no_of_out_of_commission_beds');
            $table->timestamps();
        });

        Schema::create('huddle_attendance', function (Blueprint $table) {
            $table->unsignedInteger('huddle_id');
            $table->foreign('huddle_id')->references('id')->on('huddles')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huddles');
    }
}
