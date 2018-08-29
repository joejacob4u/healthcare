<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->unsignedInteger('biomed_mission_criticality_id')->after('maintenance_redundancy_id');
            $table->foreign('biomed_mission_criticality_id', 'bmc_id')->references('id')->on('biomed_mission_criticalities')->onDelete('cascade');
            $table->unsignedInteger('equipment_incident_history_id')->after('biomed_mission_criticality_id');
            $table->foreign('equipment_incident_history_id', 'eih_id')->references('id')->on('equipment_incident_histories')->onDelete('cascade');
            $table->mediumText('preventive_maintenance_procedure')->after('equipment_incident_history_id');
            $table->string('preventive_maintenance_procedure_uploade_path')->after('preventive_maintenance_procedure');
            $table->string('baseline_date')->after('preventive_maintenance_procedure_uploade_path');
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
