<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntakeFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intake_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name');
            $table->text('project_description');
            $table->text('project_purpose');
            $table->text('project_principles');
            $table->boolean('is_con');
            $table->boolean('is_new_service_facility');
            $table->boolean('is_change_in_bed_capacity');
            $table->boolean('is_new_dialysis_or_home_services');
            $table->boolean('is_misc_services');
            $table->boolean('is_misc_equipment');
            $table->boolean('is_health_service_facility_from_health_maintenance_org');
            $table->boolean('is_healthcare_beds_to_non_healthcarebeds');
            $table->boolean('is_construction_or_establishment');
            $table->boolean('is_opening_additional_office');
            $table->boolean('is_acquisition_of_major_medical_equipment');
            $table->boolean('is_relocation_of_health_service_facility');
            $table->boolean('is_converted_to_multispeciality_surgical_program');
            $table->boolean('is_furnishing_mobile_medical_equipment');
            $table->boolean('is_gastrointestinal_or_operation_change_v1');
            $table->boolean('is_gastrointestinal_or_operation_change_v2');
            $table->string('project_information_documents_path');
            $table->string('equipment_purchase_order_amount');
            $table->string('equipment_purchase_order_documents_path');
            $table->string('copy_of_the_title_documents_path');
            $table->string('possession_letter_documents_path');
            $table->boolean('is_islm_required');
            $table->integer('islm_form_id');
            $table->boolean('is_cra_required');
            $table->boolean('is_icra_required');
            $table->boolean('is_evs_required');
            $table->boolean('is_utilities_need_upgrade');
            $table->boolean('is_displace_services_people');
            $table->boolean('is_increase_decrease_sqft');
            $table->boolean('is_project_required_completed_before_other_project');
            $table->string('project_delivery_method');
            $table->integer('project_type_component_id');
            $table->integer('project_champion_user_id');
            $table->integer('project_manager_user_id');
            $table->integer('healthsystem_admin_user_id');
            $table->string('project_status');
            $table->date('project_start_date');
            $table->date('project_end_date');
            $table->string('project_photos_directory');
            $table->integer('healthsystem_id');
            $table->integer('hco_id');
            $table->integer('site_id');
            $table->integer('building_id');
            $table->date('project_target_date');
            $table->string('rom_construction_cost');
            $table->string('rom_equipment_cost');
            $table->string('contractor_id');
            $table->date('construction_start_date');
            $table->date('construction_end_date');
            $table->date('close_out_date');
            $table->string('project_webcam');
            $table->string('status_indicator');
            $table->text('project_specific_links');
            $table->string('project_number');
            $table->string('business_unit_name');
            $table->string('capital_id_number');
            $table->string('fip_project_number');
            $table->string('ecp_project_number');
            $table->string('account_code_number');
            $table->integer('capital_project_id');
            $table->string('funding_source');
            $table->string('project_complexity');
            $table->string('project_type');
            $table->string('architecture_firm');
            $table->string('engineer_firm');
            $table->integer('construction_manager_user_id');
            $table->integer('general_contractor_user_id');
            $table->integer('trade_contractor_user_id');
            $table->integer('med_equipment_manager_user_id');
            $table->integer('commissioning_agent_user_id');
            $table->string('furniture_firm');
            $table->string('gross_sq_ft_project_completion');
            $table->string('gross_sq_ft_added_cost_center');
            $table->string('cost_center_losing_adding_sq_ft');
            $table->string('ahj');
            $table->timestamps();
        });

        Schema::create('project_type_components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('project_ranking_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('question');
            $table->timestamps();

        });

        Schema::create('project_ranking_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id');
            $table->text('answer');
            $table->string('score');
            $table->timestamps();

        });

        Schema::create('project_intake_modified_logs', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('project_intake_form_id');
            $table->datetime('modified_date');
        });

        Schema::create('capital_project_types', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intake_form');
    }
}
