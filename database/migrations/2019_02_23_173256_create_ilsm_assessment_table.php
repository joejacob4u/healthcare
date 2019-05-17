<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateIlsmAssessmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demand_work_orders', function (Blueprint $table) {
            $table->dropColumn('is_ilsm_pre_assessment_completed');
            $table->dropColumn('ilsm_preassessment_user_id');
            $table->dropColumn('ilsm_preassessment_question_1');
            $table->dropColumn('ilsm_preassessment_question_2');
            $table->dropColumn('ilsm_preassessment_question_3');
            $table->dropColumn('ilsm_question_answers');
            $table->dropColumn('is_ilsm');
            $table->dropColumn('is_ilsm_probable');
        });

        Schema::create('ilsm_assessment_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('ilsm_preassessment_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
        });
        
        Schema::create('ilsm_assessments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('demand_work_order_id');
            $table->foreign('demand_work_order_id')->references('id')->on('demand_work_orders')->onDelete('cascade');
            $table->string('ilsm_preassessment_question_answers');
            $table->unsignedInteger('ilsm_preassessment_user_id');
            $table->string('ilsm_question_answers');
            $table->unsignedInteger('ilsm_question_user_id');
            $table->unsignedInteger('ilsm_approve_user_id');
            $table->string('start_date');
            $table->string('end_date');
            $table->text('ilsm_checklist_question_answers');
            $table->boolean('is_checklist_completed');
            $table->unsignedInteger('ilsm_sign_off_user_id');
            $table->unsignedInteger('ilsm_assessment_status_id');
            $table->foreign('ilsm_assessment_status_id')->references('id')->on('ilsm_assessment_statuses')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('ilsm_assessment_statuses')->insert([
            ['name' => 'ILSM Pre-Assessment Required'],
            ['name' => 'ILSM Not Required'],
            ['name' => 'ILSM  Assessment Question Required'],
            ['name' => 'ILSM Assessment Question Approval'],
            ['name' => 'ILSM Assessment in Progress'],
            ['name' => 'ILSM Assessment Close Out'],
            ['name' => 'ILSM Complete and compliant'],
            ['name' => 'No ILSM Pre-Assessment Required'],
        ]);

        DB::table('ilsm_preassessment_questions')->insert([
            ['question' => 'Will this work restrict EGRESS from the affected space ?'],
            ['question' => 'Is the equipment, component, etc., part of a building LIFE SAFETY system ?'],
            ['question' => 'Is the activity in a Patient Care Area or will it affect a Patient Care Area ?'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ilsm_assessments');
    }
}
