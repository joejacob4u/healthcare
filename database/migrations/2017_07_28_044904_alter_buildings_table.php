<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->string('roof_sq_ft')->after('square_ft');
            $table->string('ownership')->after('roof_sq_ft');
            $table->string('sprinkled_pct')->after('ownership');
            $table->string('beds')->after('sprinkled_pct');
            $table->string('ownership_comments')->after('beds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buildings', function (Blueprint $table) {
            //
        });
    }
}
