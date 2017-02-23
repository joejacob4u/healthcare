<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRealtionships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('clients', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('email');
          $table->string('phone');
          $table->string('address');
          $table->timestamps();
      });

      Schema::create('client_jctype', function(Blueprint $table)
      {
          $table->integer('client_id')->unsigned()->nullable();
          $table->foreign('client_id')->references('id')
                ->on('clients')->onDelete('cascade');

          $table->integer('jctype_id')->unsigned()->nullable();
          $table->foreign('jctype_id')->references('id')
                ->on('jc_types')->onDelete('cascade');

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
