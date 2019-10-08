<?php

use Illuminate\Database\Seeder;

class WorkOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('equipment_work_order_statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('equipment_work_order_statuses')->insert([
            ['name' => 'Ongoing'],
            ['name' => 'Open - Parts on Order'],
            ['name' => 'BCM (Beyond Capable Maintenance) - Major Capital Needs are Required'],
            ['name' => 'Complete and Compliant'],
            ['name' => 'Pending']
        ]);
    }
}
