<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFindingsWithLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop_findings', function (Blueprint $table) {
            $table->dropColumn('is_potential_to_cause_harm');
            $table->dropColumn('location');
            $table->string('potential_to_cause_harm')->after('room_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eop_findings', function (Blueprint $table) {
            //
        });
    }
}
