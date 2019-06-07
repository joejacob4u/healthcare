<?php

use Illuminate\Database\Seeder;

class HuddleTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('huddle_tiers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('huddle_tiers')->insert([
            ['name' => 'Tier 1'],
            ['name' => 'Tier 2'],
            ['name' => 'Tier 3'],
            ['name' => 'Tier 4'],
            ['name' => 'Tier 5'],
            ['name' => 'Tier 6']
        ]);
    }
}
