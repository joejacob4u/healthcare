<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->text('address');
            $table->string('corporation');
            $table->string('partnership');
            $table->string('sole_prop');
            $table->string('company_owner');
            $table->string('contract_license_number');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('prospect_users-trades', function (Blueprint $table) {
          $table->integer('prospect_users_id');
          $table->integer('trade_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospect_users');
    }
}
