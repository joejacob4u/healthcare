<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentToBaselineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentation_baseline_dates', function (Blueprint $table) {
            $table->boolean('is_baseline_disabled')->after('baseline_date')->default(0);
            $table->string('comment')->after('is_baseline_disabled');
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
            //
        });
    }
}
