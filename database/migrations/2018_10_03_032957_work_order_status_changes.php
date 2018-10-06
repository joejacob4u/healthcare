<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class WorkOrderStatusChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_work_order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('equipment_work_order_statuses')->insert([
            ['name' => 'Ongoing'],
            ['name' => 'Open - Parts on Order'],
            ['name' => 'BCM (Beyond Capable Maintenance) - Major Capital Needs are Required'],
            ['name' => 'Complete and Compliant']
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
