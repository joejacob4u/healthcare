<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracersSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tracer_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tracer_checklist_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('tracer_section_id');
            $table->foreign('tracer_section_id')->references('id')->on('tracer_sections')->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('tracer_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('checklist_type_id');
            $table->foreign('checklist_type_id')->references('id')->on('tracer_checklist_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tracer_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracer_category_id');
            $table->foreign('tracer_category_id')->references('id')->on('tracer_categories')->onDelete('cascade');
            $table->unsignedInteger('system_tier_id');
            $table->foreign('system_tier_id')->references('id')->on('system_tiers')->onDelete('cascade');
            $table->unsignedInteger('eop_id');
            $table->string('question');
            $table->string('answer_type');
            $table->string('answers');
            $table->timestamps();
        });

        Schema::create('tracer_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });


        Schema::create('tracers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->unsignedInteger('building_department_id');
            $table->foreign('building_department_id')->references('id')->on('building_departments')->onDelete('cascade');
            $table->unsignedInteger('tracer_section_id');
            $table->foreign('tracer_section_id')->references('id')->on('tracer_sections')->onDelete('cascade');
            $table->unsignedInteger('tracer_checklist_type_id');
            $table->foreign('tracer_checklist_type_id', 'tctt_id')->references('id')->on('tracer_checklist_types')->onDelete('cascade');
            $table->unsignedInteger('tracer_status_id');
            $table->foreign('tracer_status_id', 'tst_id')->references('id')->on('tracer_statuses')->onDelete('cascade');
            $table->timestamps();
        });



        Schema::create('tracer_checklist-accreditation', function (Blueprint $table) {
            $table->unsignedInteger('tracer_checklist_id');
            $table->foreign('tracer_checklist_id', 'tct_id')->references('id')->on('tracer_checklist_types')->onDelete('cascade');
            $table->unsignedInteger('accreditation_id');
            $table->foreign('accreditation_id', 'tat_id')->references('id')->on('accreditation')->onDelete('cascade');
        });

        Schema::create('tracer_question-work_order', function (Blueprint $table) {
            $table->unsignedInteger('tracer_question_id');
            $table->foreign('tracer_question_id')->references('id')->on('tracer_questions')->onDelete('cascade');
            $table->unsignedInteger('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('demand_work_orders')->onDelete('cascade');
            $table->unsignedInteger('tracer_id');
            $table->foreign('tracer_id')->references('id')->on('tracers')->onDelete('cascade');
        });

        Schema::create('tracer_question-finding', function (Blueprint $table) {
            $table->unsignedInteger('tracer_question_id');
            $table->foreign('tracer_question_id')->references('id')->on('tracer_questions')->onDelete('cascade');
            $table->unsignedInteger('finding_id');
            $table->foreign('finding_id')->references('id')->on('eop_findings')->onDelete('cascade');
            $table->unsignedInteger('tracer_id');
            $table->foreign('tracer_id')->references('id')->on('tracers')->onDelete('cascade');
        });


        Schema::create('tracer_question_evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracer_id');
            $table->foreign('tracer_id')->references('id')->on('tracers')->onDelete('cascade');
            $table->unsignedInteger('question_id');
            $table->foreign('question_id')->references('id')->on('tracer_questions')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('finding');
            $table->timestamps();
        });

        Schema::table('tracer_questions', function (Blueprint $table) {
            $table->dropColumn('eop_id');
            $table->dropColumn('answer_type');
            $table->string('eops')->after('answers')->default('{}');
        });

        Schema::table('tracer_questions', function (Blueprint $table) {
            $table->unsignedInteger('work_order_trade_id')->after('system_tier_id');
            $table->foreign('work_order_trade_id')->references('id')->on('work_order_trades')->onDelete('cascade');
            $table->unsignedInteger('work_order_problem_id')->after('work_order_trade_id');
            $table->foreign('work_order_problem_id')->references('id')->on('work_order_problems')->onDelete('cascade');
            $table->string('negative_answer')->after('answers');
        });

        Schema::table('tracer_questions', function (Blueprint $table) {
            $table->string('answers', 500)->change();
        });


        Schema::table('tracer_questions', function (Blueprint $table) {
            $table->dropForeign(['tracer_category_id']);
            $table->dropForeign(['system_tier_id']);
            $table->dropForeign(['work_order_trade_id']);
            $table->dropForeign(['work_order_problem_id']);
            $table->unsignedInteger('system_tier_id')->default(0)->change();
            $table->unsignedInteger('work_order_trade_id')->default(0)->change();
            $table->unsignedInteger('work_order_problem_id')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracer_categories');
    }
}
