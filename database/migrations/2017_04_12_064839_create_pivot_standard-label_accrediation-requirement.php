<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotStandardLabelAccreditationRequirement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard-label_accreditation-requirement', function (Blueprint $table) {
          $table->integer('standard_label_id')->unsigned()->nullable();
          $table->foreign('standard_label_id','standard_label')->references('id')
          ->on('standard_label')->onDelete('cascade');

          $table->integer('accreditation_requirement_id')->unsigned()->nullable();
          $table->foreign('accreditation_requirement_id','accr_requirement')->references('id')
          ->on('accreditation_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standard-label_accreditation-requirement');
    }
}
