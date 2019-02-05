<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventiveMaintenanceWorkOrderInventoryStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_work_order_inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_work_order_id');
            $table->foreign('equipment_work_order_id')->references('id')->on('equipment_work_orders')->onDelete('cascade');
            $table->unsignedInteger('equipment_inventory_id');
            $table->foreign('equipment_inventory_id')->references('id')->on('equipment_inventory')->onDelete('cascade');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('comment');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('equipment_work_order_status_id');
            $table->foreign('equipment_work_order_status_id', 'ewos_id')->references('id')->on('equipment_work_order_statuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::drop('equipment_work_order-equipment_work_order_status');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_order_inventory_statuses');
    }
}
