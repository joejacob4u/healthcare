<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEnumColumnEop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop', function (Blueprint $table) {
            DB::statement("ALTER TABLE eop CHANGE COLUMN frequency frequency ENUM('no_frequency', 'daily', 'weekly','monthly','quarterly','annually','semi-annually','as_needed','per_policy','two-years','three-years','four-years','five-years','six-years')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eop', function (Blueprint $table) {
            //
        });
    }
}
