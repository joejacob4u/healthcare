<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accreditation_eop', function (Blueprint $table) {
            $table->dropColumn('standard_label');
            $table->dropColumn('standard_text');
            $table->string('accr_req_id')->after('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accreditation_eop', function (Blueprint $table) {
            //
        });
    }
}
