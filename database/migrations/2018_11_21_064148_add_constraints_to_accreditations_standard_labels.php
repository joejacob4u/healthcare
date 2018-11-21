<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsToAccreditationsStandardLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accreditations-standard_labels', function (Blueprint $table) {
            $table->foreign('accreditation_id')->references('id')->on('accreditation')->onDelete('cascade');
            $table->foreign('standard_label_id')->references('id')->on('standard_label')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accreditations-standard_labels', function (Blueprint $table) {
            //
        });
    }
}
