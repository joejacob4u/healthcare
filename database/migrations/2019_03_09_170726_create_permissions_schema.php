<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //truncate first
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('roles', function (Blueprint $table) {
            $table->string('permissions', 1000)->default('{}')->after('name');
        });

        DB::table('roles')->insert([
            ['name' => 'Master'],
            ['name' => 'System Admin'],
            ['name' => 'Admin'],
            ['name' => 'Director of Facilities'],
            ['name' => 'Facilities Manager'],
            ['name' => 'Facilities Supervisor'],
            ['name' => 'Engineering Manager'],
            ['name' => 'Inventory Manager'],
            ['name' => 'Maintenance Coordinator'],
            ['name' => 'Maintenance Technician'],
            ['name' => 'Engineering Technician'],
            ['name' => 'Safety Officer']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}
