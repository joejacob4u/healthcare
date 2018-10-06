<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotTableForWorkOrderStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_work_order-equipment_work_order_status', function (Blueprint $table) {
            $table->unsignedInteger('equipment_work_order_id');
            $table->unsignedInteger('equipment_work_order_status_id');
            $table->string('comment');
            $table->string('attachment');
        });

        Schema::table('equipment_work_orders', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('attachment');
            $table->dropColumn('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_work_order-equipment_work_order_status');
    }
}
