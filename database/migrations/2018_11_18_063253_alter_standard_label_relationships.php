<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStandardLabelRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standard_label', function (Blueprint $table) {
            $table->dropColumn('accreditation_id');
            $table->unsignedInteger('accreditation_requirement_id')->after('id');
        });

        Schema::drop('standard-label_accrediation-requirement');

        Schema::create('accreditations-standard_labels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('accreditation_id');
            $table->unsignedInteger('standard_label_id');
            $table->timestamps();
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
