<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrequalifyConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prequalify_config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('healthsystem_id');
            $table->string('input_type');
            $table->string('action_type');
            $table->string('value');
            $table->string('description');
            $table->boolean('is_required');
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
        Schema::dropIfExists('prequalify_config');
    }
}
