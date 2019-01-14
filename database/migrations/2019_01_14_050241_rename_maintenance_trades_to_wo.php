<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameMaintenanceTradesToWo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('maintenance_trades', 'work_order_trades');
        Schema::rename('maintenance_problems', 'work_order_problems');

        Schema::disableForeignKeyConstraints();

        Schema::table('work_order_problems', function (Blueprint $table) {
            $table->unsignedInteger('work_order_trade_id')->after('id');
            $table->foreign('work_order_trade_id', 'woti_id')->references('id')->on('work_order_trades')->onDelete('cascade');
            $table->dropForeign('maintenance_problems_maintenance_trade_id_foreign');
            $table->dropColumn('maintenance_trade_id');
            $table->string('priority')->after('name');
        });

        Schema::table('work_order_trades', function (Blueprint $table) {
            $table->unsignedInteger('system_tier_id')->after('id');
            $table->foreign('system_tier_id', 'sti_id')->references('id')->on('system_tiers')->onDelete('cascade');
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
        Schema::table('maintenance_trades', function (Blueprint $table) {
            //
        });
    }
}
