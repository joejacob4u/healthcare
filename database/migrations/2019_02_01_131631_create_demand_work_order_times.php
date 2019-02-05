<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandWorkOrderTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demand_work_order_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('demand_work_order_id');
            $table->foreign('demand_work_order_id')->references('id')->on('demand_work_orders')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('comment');
            $table->string('attachment');
            $table->unsignedInteger('equipment_work_order_status_id');
            $table->foreign('equipment_work_order_status_id', 'iewos_id')->references('id')->on('equipment_work_order_statuses')->onDelete('cascade');
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
        Schema::dropIfExists('demand_work_order_times');
    }
}
