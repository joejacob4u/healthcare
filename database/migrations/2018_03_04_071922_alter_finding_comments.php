<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFindingComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop_finding_comments', function (Blueprint $table) {
            $table->integer('assigned_user_id')->after('status');
            $table->dateTime('due_date')->after('assigned_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eop_finding_comments', function (Blueprint $table) {
            //
        });
    }
}
