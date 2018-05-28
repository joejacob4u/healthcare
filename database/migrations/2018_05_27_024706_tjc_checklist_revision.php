<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TjcChecklistRevision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('tjc_checklist_eops');

        Schema::drop('tjc_checklist_standards');

        Schema::create('tjc_checklist_eops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('healthsystem_id');
            $table->unsignedInteger('eop_id');
            $table->foreign('healthsystem_id')->references('id')->on('healthsystem')->onDelete('cascade');
            $table->foreign('eop_id')->references('id')->on('eop')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tjc_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tjc_checklist_eop_id');
            $table->unsignedInteger('user_id');
            $table->string('surveyor_name');
            $table->string('surveyor_email');
            $table->string('surveyor_phone');
            $table->string('surveyor_organization');
            $table->string('is_in_policy');
            $table->string('is_implemented_as_required');
            $table->string('eoc_ls_status');
            $table->foreign('tjc_checklist_eop_id')->references('id')->on('tjc_checklist_eops')->onDelete('cascade');
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
        Schema::table('tjc_checklist_eops', function (Blueprint $table) {
            //
        });
    }
}
