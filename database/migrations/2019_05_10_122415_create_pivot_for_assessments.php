<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotForAssessments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_question-work_order', function (Blueprint $table) {
            $table->unsignedInteger('assessment_question_id');
            $table->foreign('assessment_question_id')->references('id')->on('assessment_questions')->onDelete('cascade');
            $table->unsignedInteger('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('demand_work_orders')->onDelete('cascade');
            $table->unsignedInteger('assessment_id');
            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
        });

        Schema::create('assessment_question-finding', function (Blueprint $table) {
            $table->unsignedInteger('assessment_question_id');
            $table->foreign('assessment_question_id')->references('id')->on('assessment_questions')->onDelete('cascade');
            $table->unsignedInteger('finding_id');
            $table->foreign('finding_id')->references('id')->on('eop_findings')->onDelete('cascade');
            $table->unsignedInteger('assessment_id');
            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
        });


        Schema::create('assessment_question_evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assessment_id');
            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
            $table->unsignedInteger('question_id');
            $table->foreign('question_id')->references('id')->on('assessment_questions')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('finding');
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
        Schema::dropIfExists('assessmeent_question-work_order');
    }
}
