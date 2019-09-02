<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevertTracersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracers', function (Blueprint $table) {
            $table->dropColumn('room_id');
            $table->dropColumn('comments');
            $table->dropColumn('is_follow_up');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracers', function (Blueprint $table) {
            //
        });
    }
}
