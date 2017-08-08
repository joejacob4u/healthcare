<?php

use Illuminate\Database\Seeder;

class UserTradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('trades')->insert([
        ['name' => 'Master'],
        ['name' => 'Super Admin'],
        ['name' => 'Admin'],
        ['name' => 'Construction Manager, Project Manager, Program Manager'],
        ['name' => 'Materials Testing Agency'],
        ['name' => 'Specialty Testing/Inspection Agency'],
        ['name' => 'Architect'],
        ['name' => 'Structural Engineer'],
        ['name' => 'Mechanical Engineer'],
        ['name' => 'Electrical Engineer'],
        ['name' => 'Civil Engineer'],
        ['name' => 'General Engineering Contractor'],
        ['name' => 'General Building Contractor'],
        ['name' => 'Insulation and Acoustical Contractor'],
        ['name' => 'Boiler, Hot Water Heating and Steam Fitting Contractor'],
        ['name' => 'Framing and Rough Carpentry Contractor'],
        ['name' => 'Cabinet, Millwork and Finish Carpentry Contractor'],
        ['name' => 'Low Voltage Systems Contractor'],
        ['name' => 'Concrete Contractor'],
        ['name' => 'Drywall Contractor'],
        ['name' => 'Electrical Contractor'],
        ['name' => 'Elevator Contractor'],
        ['name' => 'Earthwork and Paving Contractors'],
        ['name' => 'Fencing Contractor'],
        ['name' => 'Flooring and Floor Covering Contractors'],
        ['name' => 'Fire Protection Contractor'],
        ['name' => 'Glazing Contractor'],
        ['name' => 'Warm-Air Heating, Ventilating and Air-Conditioning Contractor'],
        ['name' => 'Building Moving/Demolition Contractor'],
        ['name' => 'Ornamental Metal Contractor'],
        ['name' => 'Landscaping Contractor'],
        ['name' => 'Lock and Security Equipment Contractor'],
        ['name' => 'Masonry Contractor'],
        ['name' => 'Construction Zone Traffic Control Contractor'],
        ['name' => 'Parking and Highway Improvement Contractor'],
        ['name' => 'Painting and Decorating Contractor'],
        ['name' => 'Pipeline Contractor'],
        ['name' => 'Lathing and Plastering Contractor'],
        ['name' => 'Plumbing Contractor'],
        ['name' => 'Refrigeration Contractor'],
        ['name' => 'Roofing Contractor'],
        ['name' => 'Sanitation System Contractor'],
        ['name' => 'Sheet Metal Contractor'],
        ['name' => 'Sign Contractor'],
        ['name' => 'Solar Contractor'],
        ['name' => 'Reinforcing Steel Contractor'],
        ['name' => 'Structural Steel Contractor'],
        ['name' => 'Ceramic and Mosaic Tile Contractor'],
        ['name' => 'Water Conditioning Contractor'],
        ['name' => 'Water Well Drilling Contractor'],
        ['name' => 'Welding Contractor'],
        ['name' => 'Limited Specialty'],
        ['name' => 'ASB - Asbestos Certification'],
        ['name' => 'HAZ - Hazardous Substance Removal Certification']]
      );
    }
  }
