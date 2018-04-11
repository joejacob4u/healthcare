<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityAndBenefitForFinding extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop_findings', function (Blueprint $table) {
            $table->string('benefit')->after('internal_notes');
            $table->string('activity')->after('benefit');
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
