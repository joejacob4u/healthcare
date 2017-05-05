<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccrediationRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accrediation_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('accr_accr-requirement', function(Blueprint $table)
        {
            $table->integer('accrediation_id')->unsigned()->nullable();
            $table->foreign('accrediation_id')->references('id')
                  ->on('accrediation')->onDelete('cascade');

            $table->integer('accrediation-requirement_id')->unsigned()->nullable();
            $table->foreign('accrediation-requirement_id')->references('id')
                  ->on('accrediation_requirements')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accrediation_requirements');
    }
}
