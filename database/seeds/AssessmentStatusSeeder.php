<?php

use Illuminate\Database\Seeder;

class AssessmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('assessment_statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('assessment_statuses')->insert([
            ['name' => 'Pending'],
            ['name' => 'In Process'],
            ['name' => 'Under Review'],
            ['name' => 'Complete and Compliant'],
            ['name' => 'Complete with Open Issues']
        ]);
    }
}
