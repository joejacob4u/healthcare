<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStandardLabelAndEop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standard_label', function (Blueprint $table) {
            $table->integer('accreditation_id')->after('description');
        });

        Schema::table('eop', function (Blueprint $table) {
            $table->dropColumn('risk_assessment');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('standard_label', function (Blueprint $table) {
            //
        });
    }
}
