<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropEopLsStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjc_checklist_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tjc_checklist_id');
            $table->unsignedInteger('tjc_checklist_eop_id');
            $table->string('is_in_policy');
            $table->string('is_implemented_as_required');
            $table->foreign('tjc_checklist_eop_id')->references('id')->on('tjc_checklist_eops')->onDelete('cascade');
            $table->foreign('tjc_checklist_id')->references('id')->on('tjc_checklists')->onDelete('cascade');
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
        Schema::table('tjc_checklist_status', function (Blueprint $table) {
            //
        });
    }
}
