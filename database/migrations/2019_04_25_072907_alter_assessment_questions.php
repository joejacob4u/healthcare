<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAssessmentQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->dropForeign(['assessment_category_id']);
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
        Schema::table('assessment_questions', function (Blueprint $table) {
            //
        });
    }
}
