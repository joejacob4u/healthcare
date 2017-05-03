<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewEopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('accreditation_requirement_id');
            $table->boolean('documentation');
            $table->enum('frequency',['daily','weekly','monthly','yearly']);
            $table->boolean('risk');
            $table->boolean('risk_assessment');
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
        Schema::dropIfExists('eop');
    }
}
