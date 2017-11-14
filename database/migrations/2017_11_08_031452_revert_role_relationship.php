<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevertRoleRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->after('remember_token')->default(0);
            $table->integer('healthsystem_id')->after('role_id')->default(0);
            $table->dropColumn('is_contractor');
        });

        Schema::table('contractors', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->string('name')->after('id');
            $table->string('email')->after('name')->unique();
            $table->string('phone')->after('email');
            $table->text('address')->after('phone');
            $table->string('password')->after('address');
            $table->rememberToken()->after('contract_license_number');
            $table->dropColumn('status');
        });

        Schema::create('contractor_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });


        Schema::create('contractor_trade',function (Blueprint $table) {
            $table->integer('contractor_id');
            $table->integer('trade_id');
        });

        Schema::create('contractor_healthsystem',function (Blueprint $table) {
            $table->integer('contractor_id');
            $table->integer('healthsystem_id');
            $table->boolean('is_active')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
