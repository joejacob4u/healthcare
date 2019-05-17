<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePivotTableForEopFindingAndRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('eop_findings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('eop_findings', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });


        Schema::create('eop_finding-room', function (Blueprint $table) {
            $table->unsignedInteger('eop_finding_id');
            $table->foreign('eop_finding_id')->references('id')->on('eop_findings')->onDelete('cascade');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eop_finding-room');
    }
}
