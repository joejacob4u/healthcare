<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddImagePathToDemandWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        DB::table('work_order_priorities')->insert(
            [
                ['name' => 'Stat - (Emergency)'],
                ['name' => '1st Priority'],
                ['name' => '2nd Priority'],
                ['name' => '3rd Priority'],
                ['name' => '4th Priority'],
            ]
        );


        Schema::table('demand_work_orders', function (Blueprint $table) {
            $table->unsignedInteger('work_order_priority_id')->after('work_order_problem_id');
            $table->foreign('work_order_priority_id')->references('id')->on('work_order_priorities')->onDelete('cascade');
            $table->string('attachments_path')->after('work_order_priority_id');
            $table->dropForeign(['inventory_id']);
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
