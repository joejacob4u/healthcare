<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demand_work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('requester_name');
            $table->string('requester_email');
            $table->unsignedInteger('hco_id');
            $table->foreign('hco_id')->references('id')->on('hco')->onDelete('cascade');
            $table->unsignedInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->unsignedInteger('inventory_id');
            $table->foreign('inventory_id')->references('id')->on('equipment_inventory')->onDelete('cascade');
            $table->unsignedInteger('building_department_id');
            $table->foreign('building_department_id')->references('id')->on('building_departments')->onDelete('cascade');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->unsignedInteger('work_order_trade_id');
            $table->foreign('work_order_trade_id')->references('id')->on('work_order_trades')->onDelete('cascade');
            $table->unsignedInteger('work_order_problem_id');
            $table->foreign('work_order_problem_id')->references('id')->on('work_order_problems')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demand_work_orders');
    }
}
