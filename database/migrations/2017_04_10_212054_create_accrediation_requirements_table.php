<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccreditationRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreditation_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('accr_accr-requirement', function(Blueprint $table)
        {
            $table->integer('accreditation_id')->unsigned()->nullable();
            $table->foreign('accreditation_id')->references('id')
                  ->on('accreditation')->onDelete('cascade');

            $table->integer('accreditation-requirement_id')->unsigned()->nullable();
            $table->foreign('accreditation-requirement_id')->references('id')
                  ->on('accreditation_requirements')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accreditation_requirements');
    }
}
