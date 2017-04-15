<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotAccrediationSubCopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accrediation_sub-cop', function (Blueprint $table) {
          $table->integer('accrediation_id')->unsigned()->nullable();
          $table->foreign('accrediation_id','accr_id')->references('id')
                ->on('accrediation')->onDelete('cascade');

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
        Schema::dropIfExists('accrediation_sub-cop');
    }
}
