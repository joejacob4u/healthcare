<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Equipment\WorkOrderStatus;

class CleanUpWorkOrderStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        WorkOrderStatus::truncate();

        DB::table('equipment_work_order_statuses')->insert([
            ['name' => 'Complete and Compliant'],
            ['name' => 'Pending'],
            ['name' => 'Open - Parts on Order'],
            ['name' => 'BCM (Beyond Capable Maintenance) - Major Capital Needs are Required']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_work_order_statuses', function (Blueprint $table) {
            //
        });
    }
}
