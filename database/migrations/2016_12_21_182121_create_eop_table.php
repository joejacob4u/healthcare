<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreditation_eop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('standard_label');
            $table->string('standard_text');
            $table->string('elements_of_performance');
            $table->boolean('documentation');
            $table->string('frequency');
            $table->boolean('risk');
            $table->boolean('risk_assessment');
            $table->timestamps();
        });

        Schema::create('eop_id-eop_reference_id', function (Blueprint $table) {
            $table->integer('eop_id')->unsigned();
            $table->integer('eop_reference_id')->unsigned();
            $table->foreign('eop_id')->references('id')->on('accreditation_eop')->onDelete('cascade');
            $table->foreign('eop_reference_id')->references('id')->on('accreditation_eop')->onDelete('cascade');
    });
  }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accreditation_eop');
    }
}
