<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWarrantyToEquipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->integer('is_warranty_available')->after('identification_number');
            $table->string('warranty_start_date')->after('is_warranty_available');
            $table->string('warranty_end_date')->after('warranty_start_date');
            $table->text('warranty_company_info')->after('warranty_end_date');
            $table->string('warranty_files_path')->after('warranty_company_info');
            $table->text('warranty_description')->after('warranty_files_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipments', function (Blueprint $table) {
            //
        });
    }
}
