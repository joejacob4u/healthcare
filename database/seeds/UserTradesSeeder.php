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
        ['name' => 'Construction Manager, Project Manager'],
        ['name' => 'Materials Testing Agency'],
        ['name' => 'Specialty Testing/Inspection Agency'],
        ['name' => 'Architect'],
        ['name' => 'Acoustical Engineer'],
        ['name' => 'Structural Engineer'],
        ['name' => 'Mechanical Engineer'],
        ['name' => 'Electrical Engineer'],
        ['name' => 'Plumbing Engineer'],
        ['name' => 'Civil Engineer'],
        ['name' => 'Medical Equipment Manager'],
        ['name' => 'Commissioning Agent'],
        ['name' => 'General Contractor'],
        ['name' => 'Procurement and Contracting Requirements'],
        ['name' => 'General Requirements Subgroup'],
        ['name' => 'Existing Conditions'],
        ['name' => 'Concrete'],
        ['name' => 'Masonry'],
        ['name' => 'Metals'],
        ['name' => 'Wood, Plastics, and Composites'],
        ['name' => 'Thermal and Moisture Protection'],
        ['name' => 'Openings'],
        ['name' => 'Finishes'],
        ['name' => 'Equipment'],
        ['name' => 'Specialties'],
        ['name' => 'Furnishings'],
        ['name' => 'Special Construction'],
        ['name' => 'Conveying Equipment'],
        ['name' => 'Fire Suppression'],
        ['name' => 'Plumbing'],
        ['name' => 'Heating, Ventilating, and Air Conditioning (HVAC)'],
        ['name' => 'Integrated Automation'],
        ['name' => 'Electrical'],
        ['name' => 'Communications'],
        ['name' => 'Electronic Safety and Security'],
        ['name' => 'Earthwork'],
        ['name' => 'Exterior Improvements'],
        ['name' => 'Utilities'],
        ['name' => 'Transportation'],
        ['name' => 'Waterway and Marine Construction'],
        ['name' => 'Process Integration'],
        ['name' => 'Material Processing and Handling Equipment'],
        ['name' => 'Process Heating, Cooling, and Drying Equipment '],
        ['name' => 'Process Gas and Liquid Handling, Purification, and Storage Equipment'],
        ['name' => 'Pollution and Waste Control Equipment'],
        ['name' => 'Industry-Specific Manufacturing Equipment'],
        ['name' => 'Water and Wastewater Equipment'],
        ['name' => 'Electrical Power Generation'],
        ]
      );
    }
  }
