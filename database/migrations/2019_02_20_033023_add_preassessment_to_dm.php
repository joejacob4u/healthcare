<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreassessmentToDm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demand_work_orders', function (Blueprint $table) {
            $table->boolean('is_ilsm_pre_assessment_completed')->default(0)->after('is_ilsm_probable');
            $table->string('ilsm_preassessment_question_1')->nullable()->after('is_ilsm_pre_assessment_completed');
            $table->string('ilsm_preassessment_question_2')->nullable()->after('ilsm_preassessment_question_1');
            $table->string('ilsm_preassessment_question_3')->nullable()->after('ilsm_preassessment_question_2');
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
