<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClientsSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hco', function (Blueprint $table) {
            $table->boolean('is_need_state')->default(0)->after('hco_id');
            $table->string('hco_logo')->after('is_need_state');
            
        });

        Schema::table('buildings', function (Blueprint $table) {
            $table->string('building_logo')->after('unused_space');
            $table->string('building_img_dir')->after('building_logo');
        });

        Schema::table('healthsystem', function (Blueprint $table) {
            $table->string('healthsystem_logo')->after('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hco', function (Blueprint $table) {
            //
        });
    }
}
