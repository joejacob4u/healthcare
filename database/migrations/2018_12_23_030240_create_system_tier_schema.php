<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSystemTierSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_tiers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('work_order_questionnaires', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('system_tier_id');
            $table->foreign('system_tier_id')->references('id')->on('system_tiers')->onDelete('cascade');
            $table->string('question');
            $table->timestamps();
        });

        DB::table('system_tiers')->insert(
            [
            ['name' => 'Facilities Maintenance'],
            ['name' => 'Environmental Services'],
            ['name' => 'BioMed/Clinical Engineering'],
            ['name' => 'Grounds'],
            ['name' => 'Information Technology/Services'],
            ['name' => 'Safety/Security'],
            ['name' => 'Food & Nutrition'],
            ['name' => 'Construction'],
            ['name' => 'Energy Management Solutions'],
            ['name' => 'Hospitality & Valet'],
            ['name' => 'Parking & Shuttle'],
            ['name' => 'Patient Observation'],
            ['name' => 'Patient Transportation'],
            ['name' => 'Linen & Laundry']
            ]
        );

        Schema::table('equipment_asset_categories', function (Blueprint $table) {
            $table->dropColumn('required_by');
            $table->unsignedInteger('system_tier_id')->after('equipment_category_id');
            $table->foreign('system_tier_id')->references('id')->on('system_tiers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_tiers', function (Blueprint $table) {
            //
        });
    }
}
