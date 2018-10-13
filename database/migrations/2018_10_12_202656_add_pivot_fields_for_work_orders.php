<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPivotFieldsForWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_work_order-equipment_work_order_status', function (Blueprint $table) {
            $table->integer('user_id')->after('equipment_work_order_status_id');
            $table->string('start_time')->after('user_id');
            $table->string('end_time')->after('start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_work_order-equipment_work_order_status', function (Blueprint $table) {
            //
        });
    }
}
