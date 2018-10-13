<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFieldsFromWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_work_orders', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('parts_on_order');
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
