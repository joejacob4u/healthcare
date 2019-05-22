<?php

use Illuminate\Database\Seeder;

class TracerStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tracer_statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('tracer_statuses')->insert([
            ['name' => 'Pending'],
            ['name' => 'In Process'],
            ['name' => 'Under Review'],
            ['name' => 'Complete and Compliant'],
            ['name' => 'Complete with Open Issues']
        ]);
    }
}
