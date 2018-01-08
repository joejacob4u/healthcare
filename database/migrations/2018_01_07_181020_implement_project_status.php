<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImplementProjectStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
        });

        Schema::create('project_statuses_healthsystem', function (Blueprint $table) {
            $table->integer('project_status_id');
            $table->integer('healthsystem_id');
            $table->string('estimated_start_date');
            $table->string('estimated_end_date');
            $table->string('actual_end_date');
            $table->string('note');
            $table->boolean('is_completed');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_statuses');
    }
}
