<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentBaselineDateSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_baseline_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_id');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->string('date');
            $table->timestamps();
        });

        Schema::table('equipment_inventory', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['equipment_id']);
            $table->dropColumn('equipment_id');
            $table->unsignedInteger('baseline_date_id')->after('id');
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
        Schema::dropIfExists('equipment_baseline_dates');
    }
}
