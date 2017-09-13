<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['name' => 'Accident and emergency (A&E)'],
            ['name' => 'Accreditation'],
            ['name' => 'Administration'],
            ['name' => 'Anesthetics'],
            ['name' => 'Behavioral Health'],
            ['name' => 'Breast screening'],
            ['name' => 'Cardiology'],
            ['name' => 'Chaplaincy'],
            ['name' => 'Corporate Compliance/Legal'],
            ['name' => 'Critical care'],
            ['name' => 'Diagnostic imaging'],
            ['name' => 'Discharge lounge'],
            ['name' => 'Ear nose and throat (ENT)'],
            ['name' => 'Elderly services department'],
            ['name' => 'Endoscopy'],
            ['name' => 'Environmental Services (EVS)'],
            ['name' => 'Facilities/Engineering'],
            ['name' => 'Facilities Planning, Design & Construction'],
            ['name' => 'Gastroenterology'],
            ['name' => 'General Services'],
            ['name' => 'General surgery'],
            ['name' => 'Gynecology'],
            ['name' => 'Hematology'],
            ['name' => 'Health & Safety'],
            ['name' => 'Human Resources'],
            ['name' => 'Infection Control'],
            ['name' => 'Information Management'],
            ['name' => 'Maternity Mother/Baby'],
            ['name' => 'Microbiology'],
            ['name' => 'Neonatal unit'],
            ['name' => 'Nephrology'],
            ['name' => 'Neurology'],
            ['name' => 'Nutrition and Dietetics'],
            ['name' => 'Obstetrics'],
            ['name' => 'Occupational therapy'],
            ['name' => 'Oncology'],
            ['name' => 'Ophthalmology'],
            ['name' => 'Orthopaedics'],
            ['name' => 'Otolaryngology (Ear, Nose, and Throat)'],
            ['name' => 'Pain management clinics'],
            ['name' => 'Parking/Valet'],
            ['name' => 'Patient Accounts'],
            ['name' => 'Patient Services'],
            ['name' => 'Pharmacy'],
            ['name' => 'Philanthropy/Foundation'],
            ['name' => 'Physiotherapy'],
            ['name' => 'Purchasing & Supplies'],
            ['name' => 'Radiology'],
            ['name' => 'Radiotherapy'],
            ['name' => 'Renal'],
            ['name' => 'Rheumatology'],
            ['name' => 'Risk'],
            ['name' => 'Sexual health (genitourinary medicine)'],
            ['name' => 'Sexual Assault Trauma Unit (SATU)'],
            ['name' => 'Social Work'],
            ['name' => 'Urology'],


          ]);
    }
}
