<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentWorkOrderShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_work_order_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('equipment_work_orders')->onDelete('cascade');
            $table->string('start_time');
            $table->string('end_time');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('equipment_work_order_shifts');
    }
}
