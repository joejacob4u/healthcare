<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEquipmentInventory extends Migration
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

            $table->dropColumn('equipment_incident_history_id');
            $table->dropColumn('maintenance_redundancy_id');
            
            //rename some columns
            $table->renameColumn('preventive_maintenance_procedure_uploade_path', 'preventive_maintenance_procedure_upload_path');

            //drop some columns
            $table->dropColumn('serial_number');
            $table->dropColumn('identification_number');
            $table->dropColumn('warranty_start_date');
            $table->dropColumn('warranty_end_date');
            $table->dropColumn('manufacturer_date');
            $table->dropColumn('department_id');
            $table->dropColumn('room_id');
            $table->dropColumn('estimated_deferred_maintenance_cost');
            $table->dropColumn('estimated_replacement_cost');
            $table->dropColumn('baseline_date');

            //add new columns
        });

        Schema::create('equipment_inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_id');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->string('name');
            $table->string('serial_number');
            $table->string('identification_number');
            $table->string('installation_date');
            $table->string('warranty_period');
            $table->string('warranty_start_date');
            $table->string('estimated_replacement_cost');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('building_departments')->onDelete('cascade');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->string('estimated_deferred_maintenance_cost');
            $table->unsignedInteger('biomed_mission_criticality_id');
            $table->foreign('biomed_mission_criticality_id')->references('id')->on('biomed_mission_criticalities')->onDelete('cascade');
            $table->unsignedInteger('equipment_incident_history_id');
            $table->foreign('equipment_incident_history_id')->references('id')->on('equipment_incident_histories')->onDelete('cascade');
            $table->unsignedInteger('maintenance_redundancy_id');
            $table->foreign('maintenance_redundancy_id')->references('id')->on('equipment_redundancies')->onDelete('cascade');
            $table->timestamps();
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
