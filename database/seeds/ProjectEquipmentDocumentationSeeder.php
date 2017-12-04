<?php

use Illuminate\Database\Seeder;

class ProjectEquipmentDocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_equipment_documentation')->insert([
            ['name' => 'Type of Equipment'],
            ['name' => 'Manufacturer of Equipment'],
            ['name' => 'Tesls Rating for MRIs'],
            ['name' => 'Model Number'],
            ['name' => 'Serial Number'],
            ['name' => 'Providers Method of Identifying'],
            ['name' => 'Specify If Mobile or Fixed'],
            ['name' => 'Mobile Trailer Serial Number / VIN#'],
            ['name' => 'Mobile Tractor Serial Number / VIN#'],
            ['name' => 'Date of Aquisition of Each Component'],
            ['name' => 'Does Provider Hold Title to Equipment or Have a Capital Lease?'],
            ['name' => 'Specify if Equipment Was/Is New or Used When Acquired'],
            ['name' => 'Total Capital Cost of Project'],
            ['name' => 'Total Cost of Equipment'],
            ['name' => 'Fair Market Value of Equipment'],
            ['name' => 'Net Purchase Price of Equipment'],
            ['name' => 'Locations Where Operated'],
            ['name' => 'Number Days in Use/To be Used in N.C Per Year'],
            ['name' => 'Percentage of Change in Patient Charges'],
            ['name' => 'Percentage of Change in Per Procedure Operating Expenses'],
            ['name' => 'Type of Procedures Currently Performed on Existing Equipment'],
            ['name' => 'Type of Procedures New Equipment is Capable of Performing']
          ]);
    }
}
