<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuildingIdToTjcChecklists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tjc_checklists', function (Blueprint $table) {
            $table->dropColumn('hco_id');
            $table->unsignedInteger('building_id')->after('id');
            $table->string('activity')->after('surveyor_organization');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tjc_checklists', function (Blueprint $table) {
            //
        });
    }
}
