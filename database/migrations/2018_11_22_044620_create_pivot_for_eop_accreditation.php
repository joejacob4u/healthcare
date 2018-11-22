<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotForEopAccreditation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('accr_requirements');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('accreditation_eop');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('accreditations_eops', function (Blueprint $table) {
            $table->integer('accreditation_id')->unsigned();
            $table->foreign('accreditation_id')->references('id')->on('accreditation')->onDelete('cascade');
            $table->integer('eop_id')->unsigned();
            $table->foreign('eop_id')->references('id')->on('eop')->onDelete('cascade');
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
