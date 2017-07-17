<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('client_accrtype');
        Schema::drop('client_department');
        Schema::drop('clients');

        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('healthcare_system');
            $table->string('facility_name');
            $table->string('address');
            $table->string('hco_id');
            $table->string('admin_name');
            $table->string('admin_email');
            $table->string('admin_phone');
            $table->string('state');
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
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
