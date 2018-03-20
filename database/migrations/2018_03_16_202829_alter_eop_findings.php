<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEopFindings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop_findings', function (Blueprint $table) {
            $table->integer('healthsystem_id')->after('id');
            $table->integer('building_id')->after('healthsystem_id');
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
