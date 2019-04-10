<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRoundingQuestionPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rounding_question_finding-work_order')->truncate();
        Schema::dropIfExists('rounding_question_finding-work_order');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('rounding_question-work_order', function (Blueprint $table) {
            $table->unsignedInteger('rounding_question_id');
            $table->foreign('rounding_question_id')->references('id')->on('rounding_questions')->onDelete('cascade');
            $table->unsignedInteger('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('demand_work_orders')->onDelete('cascade');
            $table->unsignedInteger('rounding_id');
            $table->foreign('rounding_id')->references('id')->on('roundings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rounding_question-work_order');
    }
}
