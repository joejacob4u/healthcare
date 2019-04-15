<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentQuestionSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assessment_category_id');
            $table->foreign('assessment_category_id')->references('id')->on('assessment_categories')->onDelete('cascade');
            $table->unsignedInteger('system_tier_id');
            $table->foreign('system_tier_id')->references('id')->on('system_tiers')->onDelete('cascade');
            $table->unsignedInteger('eop_id');
            $table->string('question');
            $table->string('answer_type');
            $table->string('answers');
            $table->timestamps();
        });

        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->dropColumn('eop_id');
            $table->dropColumn('answer_type');
            $table->string('eops')->after('answers')->default('{}');
        });

        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->unsignedInteger('work_order_trade_id')->after('system_tier_id');
            $table->foreign('work_order_trade_id')->references('id')->on('work_order_trades')->onDelete('cascade');
            $table->unsignedInteger('work_order_problem_id')->after('work_order_trade_id');
            $table->foreign('work_order_problem_id')->references('id')->on('work_order_problems')->onDelete('cascade');
            $table->string('negative_answer')->after('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_questions');
    }
}
