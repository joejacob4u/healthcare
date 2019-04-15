<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_checklist_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('assessment_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('checklist_type_id');
            $table->foreign('checklist_type_id')->references('id')->on('assessment_checklist_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('assessment_checklist-accreditation', function (Blueprint $table) {
            $table->unsignedInteger('assessment_checklist_id');
            $table->foreign('assessment_checklist_id', 'ac_id')->references('id')->on('assessment_checklist_types')->onDelete('cascade');
            $table->unsignedInteger('accreditation_id');
            $table->foreign('accreditation_id', 'a_id')->references('id')->on('accreditation')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_checklist_types');
    }
}
