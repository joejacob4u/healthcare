<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoundingsSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roundings', function (Blueprint $table) {
            $table->dropColumn('answers');
        });

        Schema::create('rounding_question_findings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rounding_id');
            $table->foreign('rounding_id')->references('id')->on('roundings')->onDelete('cascade');
            $table->unsignedInteger('question_id');
            $table->foreign('question_id')->references('id')->on('rounding_questions')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('finding');
            $table->timestamps();
        });

        Schema::create('rounding_question_finding-work_order', function (Blueprint $table) {
            $table->unsignedInteger('rounding_question_finding_id');
            $table->foreign('rounding_question_finding_id', 'rqf_id')->references('id')->on('rounding_question_findings')->onDelete('cascade');
            $table->unsignedInteger('demand_work_order_id');
            $table->foreign('demand_work_order_id', 'dwo_id')->references('id')->on('demand_work_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roundings', function (Blueprint $table) {
            //
        });
    }
}
