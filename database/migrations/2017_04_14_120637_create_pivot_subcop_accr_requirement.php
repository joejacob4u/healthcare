<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotSubcopAccrRequirement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accrediation-req_sub-cop', function (Blueprint $table) {
          $table->integer('accrediation_requirement_id')->unsigned()->nullable();
          $table->foreign('accrediation_requirement_id','accr_req_id')->references('id')
                ->on('accrediation_requirements')->onDelete('cascade');

          $table->integer('sub_cop_id')->unsigned()->nullable();
          $table->foreign('sub_cop_id')->references('id')
                ->on('sub_cop')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accrediation-req_sub-cop');
    }
}
