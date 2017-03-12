<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotSubCopEop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('subcop_accrtypes', function(Blueprint $table)
      {
      $table->integer('subcop_id')->unsigned()->nullable();
      $table->foreign('subcop_id')->references('id')
            ->on('sub_cop')->onDelete('cascade');

      $table->integer('accrtype_id')->unsigned()->nullable();
      $table->foreign('accrtype_id')->references('id')
            ->on('accr_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
