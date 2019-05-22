<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(RoundingStatusSeeder::class);
        $this->call(AssessmentStatusSeeder::class);
        $this->call(TracerStatusSeeder::class);
    }
}
