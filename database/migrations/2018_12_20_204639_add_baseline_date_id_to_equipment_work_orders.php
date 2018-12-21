<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaselineDateIdToEquipmentWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_work_orders', function (Blueprint $table) {
            $table->unsignedInteger('baseline_date_id')->after('building_id');
            $table->foreign('baseline_date_id')->references('id')->on('equipment_baseline_dates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_work_orders', function (Blueprint $table) {
            //
        });
    }
}
