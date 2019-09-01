<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTracersSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracers', function (Blueprint $table) {
            $table->boolean('room_id')->after('user_id')->default(0);
            $table->string('comments')->after('room_id')->default(0);
            $table->boolean('is_follow_up')->after('comments')->default(0);
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
