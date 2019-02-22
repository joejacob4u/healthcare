<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssessmentUserToDm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demand_work_orders', function (Blueprint $table) {
            $table->unsignedInteger('ilsm_preassessment_user_id')->nullable()->after('is_ilsm_pre_assessment_completed');
            $table->string('ilsm_question_answers')->after('ilsm_preassessment_question_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demand_work_orders', function (Blueprint $table) {
            //
        });
    }
}
