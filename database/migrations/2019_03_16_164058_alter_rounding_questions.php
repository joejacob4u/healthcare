<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRoundingQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rounding_questions', function (Blueprint $table) {
            $table->dropColumn('eop_id');
            $table->dropColumn('answer_type');
            $table->string('eops')->after('answers')->default('{}');
            ;
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
