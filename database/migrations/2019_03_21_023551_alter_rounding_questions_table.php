<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoundingQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rounding_questions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('rounding_questions', function (Blueprint $table) {
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
        Schema::table('rounding_questions', function (Blueprint $table) {
            //
        });
    }
}
