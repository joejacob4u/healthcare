<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddUserToIlsmChecklists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ilsm_checklists')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('ilsm_checklists', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after('answers');
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
        Schema::table('ilsm_checklists', function (Blueprint $table) {
            //
        });
    }
}
