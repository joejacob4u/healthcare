<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateToNewDept extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::rename('accr_types', 'departments');
      Schema::rename('accr_requirements', 'accr_types');

      Schema::create('client_department', function(Blueprint $table)
      {
          $table->integer('client_id')->unsigned()->nullable();
          $table->foreign('client_id')->references('id')
                ->on('clients')->onDelete('cascade');

          $table->integer('department_id')->unsigned()->nullable();
          $table->foreign('department_id')->references('id')
                ->on('departments')->onDelete('cascade');

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
