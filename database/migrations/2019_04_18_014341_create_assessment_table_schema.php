<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentTableSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('assessments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->unsignedInteger('building_department_id');
            $table->foreign('building_department_id')->references('id')->on('building_departments')->onDelete('cascade');
            $table->unsignedInteger('assessment_section_id');
            $table->foreign('assessment_section_id')->references('id')->on('assessment_sections')->onDelete('cascade');
            $table->unsignedInteger('assessment_checklist_type_id');
            $table->foreign('assessment_checklist_type_id', 'act_id')->references('id')->on('assessment_checklist_types')->onDelete('cascade');
            $table->unsignedInteger('assessment_status_id');
            $table->foreign('assessment_status_id', 'as_id')->references('id')->on('assessment_statuses')->onDelete('cascade');
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
        Schema::dropIfExists('assessments');
    }
}
