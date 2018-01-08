<?php

use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_statuses')->insert([
            ['status' => 'Project Development Request Submitted'],
            ['status' => 'Pre-Planning/Project Discovery/Feasibility/Preliminary Estimating'],
            ['status' => 'Obtaining Bids'],
            ['status' => 'Submitted for Approval–Pending Funding'],
            ['status' => 'Work In Progress - Planning'],
            ['status' => 'Work In Progress - Design'],
            ['status' => 'Work In Progress - Construction'],
            ['status' => 'Work Complete'],
            ['status' => 'Work Complete - Administrative/Training'],
            ['status' => 'Work Complete - Closeout'],
            ['status' => 'Project Canceled'],
            ]
          );
    }
}
