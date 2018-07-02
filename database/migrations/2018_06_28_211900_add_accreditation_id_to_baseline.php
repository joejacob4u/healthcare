<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccreditationIdToBaseline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentation_baseline_dates', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documentation_baseline_dates', function (Blueprint $table) {
            if (Schema::hasColumn('documentation_baseline_dates', 'accreditation_id')) {
                //
            } else {
                $table->unsignedInteger('accreditation_id')->after('id');
            }
        });
    }
}
