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
      DB::table('roles')->insert([
        ['name' => 'Master'],
        ['name' => 'Super Admin'],
        ['name' => 'Admin'],
        ['name' => 'Facility Manager/Director'],
        ['name' => 'Maintenance Technician'],
        ['name' => 'Project Manager/Construction Manager'],
        ['name' => 'Business Partner'],
        ['name' => 'Infection Prevention'],
        ['name' => 'Safety'],
        ['name' => 'Accreditation'],
        ['name' => 'Administration']]
      );
    }
  }
