<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DemandWorkOrderAddMultipleRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('demand_work_order_shifts')->truncate();
        DB::table('demand_work_orders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('demand_work_orders', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });

        Schema::create('demand_work_orders-rooms', function (Blueprint $table) {
            $table->unsignedInteger('demand_work_order_id');
            $table->foreign('demand_work_order_id')->references('id')->on('demand_work_orders')->onDelete('cascade');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
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
