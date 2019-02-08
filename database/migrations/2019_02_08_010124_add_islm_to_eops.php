<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIslmToEops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop', function (Blueprint $table) {
            $table->boolean('is_islm')->default(0)->after('risk');
            $table->boolean('is_islm_shift')->default(0)->after('is_islm');
            $table->integer('islm_hours_threshold')->after('is_islm_shift');
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
