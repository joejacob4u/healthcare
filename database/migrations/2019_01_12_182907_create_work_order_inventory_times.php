<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWorkOrderInventoryTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('equipment_work_order_shifts')->truncate();

        DB::table('equipment_work_order_inventory')->truncate();

        DB::table('equipment_work_order_statuses')->truncate();

        DB::table('equipment_work_order_statuses')->insert([
            ['name' => 'Complete and Compliant'],
            ['name' => 'Open - Ongoing'],
            ['name' => 'Open - Parts on Order'],
            ['name' => 'Beyond Capable Maintenance']
        ]);


        Schema::create('equipment_work_order_inventory_times', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_work_order_inventory_id');
            $table->foreign('equipment_work_order_inventory_id', 'ewo_id')->references('id')->on('equipment_work_order_inventory')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('comment');
            $table->unsignedInteger('equipment_work_order_status_id');
            $table->foreign('equipment_work_order_status_id', 'ewos_id')->references('id')->on('equipment_work_order_statuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('equipment_work_order_inventory', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('comment');
            $table->dropColumn('equipment_work_order_status_id');
        });



        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_work_order_inventory_times');
    }
}
