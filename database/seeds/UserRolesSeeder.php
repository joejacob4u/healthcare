<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
          ['name' => 'Safety Officer'],
          ['name' => 'Rounding Leader'],
          ['name' => 'Rounding Participant']
      ]);
    }
}
