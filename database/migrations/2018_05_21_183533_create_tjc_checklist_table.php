<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTjcChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjc_checklist_standards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('healthsystem_id');
            $table->unsignedInteger('standard_label_id');
            $table->foreign('healthsystem_id')->references('id')->on('healthsystem')->onDelete('cascade');
            $table->foreign('standard_label_id')->references('id')->on('standard_label')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tjc_checklist_eops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tjc_checklist_standard_id');
            $table->unsignedInteger('eop_id');
            $table->string('is_in_policy');
            $table->string('is_implemented_as_required');
            $table->string('eoc_ls_status');
            $table->foreign('tjc_checklist_standard_id')->references('id')->on('tjc_checklist_standards')->onDelete('cascade');
            $table->foreign('eop_id')->references('id')->on('eop')->onDelete('cascade');
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
        Schema::dropIfExists('tjc_checklist_standards');
    }
}
