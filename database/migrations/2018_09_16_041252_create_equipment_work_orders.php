<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('work_order_date');
            $table->unsignedInteger('building_id');
            $table->unsignedInteger('equipment_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('parts_on_order');
            $table->string('comment');
            $table->boolean('is_in_house');
            $table->string('attachment');
            $table->string('status');
            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_work_orders');
    }
}
