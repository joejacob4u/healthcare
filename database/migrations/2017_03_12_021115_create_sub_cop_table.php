<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sub_cop', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('cop_id');
          $table->string('label');
          $table->string('title');
          $table->boolean('compliant');
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
        Schema::table('sub_cop', function (Blueprint $table) {
            //
        });
    }
}
