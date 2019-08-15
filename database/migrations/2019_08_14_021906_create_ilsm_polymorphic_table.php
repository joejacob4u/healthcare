<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIlsmPolymorphicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ilsm_assessments')->truncate();

        Schema::table('ilsm_assessments', function (Blueprint $table) {
            $table->dropForeign(['demand_work_order_id']);
            $table->dropColumn('demand_work_order_id');

            $table->integer('work_order_id')->unsigned()->after('id');
            $table->string('work_order_type')->after('work_order_id');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ilsm_assessments', function (Blueprint $table) {
            //
        });
    }
}
