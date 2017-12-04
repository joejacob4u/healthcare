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
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name'); //gi
            $table->text('project_description'); //gi
            $table->text('project_purpose'); //gi
            $table->text('project_principles');//leadership
            $table->boolean('is_con');//gi
            $table->boolean('is_new_service_facility');//gi
            $table->boolean('is_change_in_bed_capacity');//gi
            $table->boolean('is_new_dialysis_or_home_services');//con gi
            $table->boolean('is_misc_services');//con gi
            $table->boolean('is_misc_equipment');//con gi
            $table->boolean('is_health_service_facility_from_health_maintenance_org'); //con gi
            $table->boolean('is_healthcare_beds_to_non_healthcarebeds');//con gi
            $table->boolean('is_construction_or_establishment');//con gi
            $table->boolean('is_opening_additional_office');//con gi
            $table->boolean('is_acquisition_of_major_medical_equipment');//con gi
            $table->boolean('is_relocation_of_health_service_facility');//con gi
            $table->boolean('is_converted_to_multispeciality_surgical_program');//con gi
            $table->boolean('is_furnishing_mobile_medical_equipment');//con gi
            $table->boolean('is_gastrointestinal_or_operation_change_v1');//con gi
            $table->boolean('is_gastrointestinal_or_operation_change_v2');//con gi
            $table->string('project_information_documents_path');//gi
            $table->string('equipment_purchase_order_amount');//financial
            $table->string('equipment_purchase_order_documents_path');//financial
            $table->string('copy_of_the_title_documents_path');//cfinancial
            $table->string('possession_letter_documents_path');//con gi
            $table->boolean('is_islm_required');//accreditation
            $table->integer('islm_form_id');//accrediatation
            $table->boolean('is_cra_required');//accrediatation
            $table->boolean('is_icra_required');//accrediatation
            $table->boolean('is_evs_required');//facilities
            $table->boolean('is_utilities_need_upgrade');//facilities
            $table->boolean('is_displace_services_people');//administrative
            $table->boolean('is_increase_decrease_sqft');//facilities
            $table->boolean('is_project_required_completed_before_other_project');//administrative
            $table->string('project_delivery_method');//administrative
            $table->integer('project_type_component_id');//leadership
            $table->integer('project_champion_user_id');//leadership
            $table->integer('project_manager_user_id');//leadership
            $table->integer('healthsystem_admin_user_id');//leadership
            $table->string('project_status');//administrative
            $table->date('project_start_date');//administrative
            $table->date('project_end_date');//administrative
            $table->string('project_photos_directory');//gi
            $table->integer('healthsystem_id');//gi
            $table->integer('hco_id');//gi
            $table->integer('site_id');//gi
            $table->integer('building_id');//gi
            $table->date('project_target_date');//gi
            $table->string('rom_construction_cost');//financial
            $table->string('rom_equipment_cost');//financial
            $table->string('contractor_id');
            $table->date('construction_start_date');//gi
            $table->date('construction_end_date');//gi
            $table->date('close_out_date');//administrative
            $table->string('project_webcam');//gi
            $table->string('status_indicator');//gi dropdown
            $table->text('project_specific_links');//gi
            $table->string('project_number');//gi
            $table->string('business_unit_name');//financial
            $table->string('capital_id_number');//financial
            $table->string('fip_project_number');//financial
            $table->string('ecp_project_number');//financial
            $table->string('account_code_number');//financial
            $table->integer('capital_project_id');//financial
            $table->string('funding_source');//financial
            $table->string('project_complexity');//facilities
            $table->string('project_type');//gi
            $table->string('architecture_firm_contractor_id');//gi
            $table->string('engineer_firm_contractor_id');//gi
            $table->integer('construction_manager_contractor_id');//gi
            $table->integer('general_contractor_contractor_id');//gi
            $table->integer('trade_contractor_contractor_id');//gi
            $table->integer('med_equipment_manager_contractor_id');
            $table->integer('commissioning_agent_contractor_id');//gi
            $table->string('furniture_firm');//gi
            $table->string('gross_sq_ft_project_completion');//gi
            $table->string('gross_sq_ft_added_cost_center');//gi
            $table->string('cost_center_losing_adding_sq_ft');//gi
            $table->string('ahj');//gi
            $table->timestamps();
        });

        Schema::create('project_equipment_documentation', function (Blueprint $table) {
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
            $table->increments('id');
            $table->string('name');
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
