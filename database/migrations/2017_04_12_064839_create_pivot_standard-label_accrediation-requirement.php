<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotStandardLabelAccrediationRequirement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard-label_accrediation-requirement', function (Blueprint $table) {
          $table->integer('standard_label_id')->unsigned()->nullable();
          $table->foreign('standard_label_id','standard_label')->references('id')
          ->on('standard_label')->onDelete('cascade');

          $table->integer('accrediation_requirement_id')->unsigned()->nullable();
          $table->foreign('accrediation_requirement_id','accr_requirement')->references('id')
          ->on('accrediation_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standard-label_accrediation-requirement');
    }
}
