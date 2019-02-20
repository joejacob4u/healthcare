<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIlsmTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ilsm_checklists', function (Blueprint $table) {
            $table->dropForeign(['ilsm_id']);
            $table->dropColumn('ilsm_id');
        });

        Schema::rename('ilsm_checklists', 'ilsm_questions');


        Schema::create('ilsm-ilsm_question', function (Blueprint $table) {
            $table->unsignedInteger('ilsm_id');
            $table->foreign('ilsm_id')->references('id')->on('ilsms')->onDelete('cascade');
            $table->unsignedInteger('ilsm_question_id');
            $table->foreign('ilsm_question_id')->references('id')->on('ilsm_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ilsms', function (Blueprint $table) {
            //
        });
    }
}
