<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateJcToAccr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('jc_types', 'accr_types');
        Schema::rename('jc_requirements', 'accr_requirements');
        Schema::drop('client_jctype');

        Schema::create('client_accrtype', function(Blueprint $table)
        {
            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')
                  ->on('clients')->onDelete('cascade');

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
