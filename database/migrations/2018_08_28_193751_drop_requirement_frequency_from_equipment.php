<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropRequirementFrequencyFromEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipments', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('effr_id');
            $table->dropColumn('equipment_frequency_requirement_id');
            $table->unsignedInteger('equipment_maintenance_requirement_id')->after('equipment_pics_path');
            $table->foreign('equipment_maintenance_requirement_id', 'eqmr_id')->references('id')->on('equipment_maintenance_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipments', function (Blueprint $table) {
            //
        });
    }
}
