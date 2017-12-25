<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectWorkflowTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('step');
            $table->string('description');
            $table->boolean('is_administrative_leader_required');
            $table->boolean('is_approval_level_leader_required');
            $table->boolean('is_accreditation_compliance_required');
            $table->timestamps();
        });

        Schema::create('approval_level_leaders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('signing_level_amount');
            $table->timestamps();
        });

        Schema::create('administrative_leaders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('workflow_approval_level_leader_id');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('accreditation_compliance_leaders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('business_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('business_unit_number');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('financial_category_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_group');
            $table->string('category');
            $table->string('category_number');
            $table->timestamps();
        });

        Schema::create('workflow_approval_level_leader', function (Blueprint $table) {
            $table->integer('workflow_id');
            $table->integer('approval_level_leader_id');
        });

        Schema::create('workflow_administrative_leader', function (Blueprint $table) {
            $table->integer('workflow_id');
            $table->integer('administrative_leader_id');
        });

        Schema::create('workflow_accreditation_compliance_leader', function (Blueprint $table) {
            $table->integer('workflow_id');
            $table->integer('accreditation_compliance_leader_id');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_workflow');
    }
}
