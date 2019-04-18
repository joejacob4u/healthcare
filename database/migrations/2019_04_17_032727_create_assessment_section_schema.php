<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentSectionSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('assessment_checklist_types')->truncate();
        DB::table('assessment_categories')->truncate();
        DB::table('assessment_questions')->truncate();
        DB::table('assessment_checklist-accreditation')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('assessment_checklist_types', function (Blueprint $table) {
            $table->unsignedInteger('assessment_section_id')->after('id');
            $table->foreign('assessment_section_id')->references('id')->on('assessment_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_sections');
    }
}
