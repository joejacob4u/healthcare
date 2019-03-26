<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRoundingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rounding_configs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('rounding_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('rounding_configs', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after('building_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


        Schema::create('roundings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rounding_config_id');
            $table->foreign('rounding_config_id', 'rc_id')->references('id')->on('rounding_configs')->onDelete('cascade');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->string('date');
            $table->text('answers');
            $table->unsignedInteger('rounding_status_id');
            $table->foreign('rounding_status_id', 'rs_id')->references('id')->on('rounding_statuses')->onDelete('cascade');
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
        Schema::dropIfExists('roundings');
    }
}
