<?php

use Illuminate\Database\Seeder;

class CapitalProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('capital_project_types')->insert([
            ['name' => 'Strategic Capital'],
            ['name' => 'Discretionary Capital'],
            ['name' => 'ECP - Energy Conservation Project'],
            ['name' => 'FIP - Facility Infrastructure Project'],
            ['name' => 'RCx - Retro-Commissioning'],
            ['name' => 'Historical'],
            ['name' => 'Real Estate Project'],
            ['name' => 'Facility Pool - Renovation'],
            ['name' => 'Facility Pool - Elevator'],
            ['name' => 'Facility Pool - Life Safety'],
            ['name' => 'Facility Pool - Parking and Roofs'],
            ['name' => 'Clinical Equipment Pool'],
            ['name' => 'Information Technology'],
            ['name' => 'Insurance Claim FINANCIAL']
          ]);
    }
}
