<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReadFieldToFindingComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop_finding_comments', function (Blueprint $table) {
            $table->boolean('is_read_by_assigned_user')->default(0)->after('due_date');
            $table->boolean('is_replied_by_assigned_user')->default(0)->after('is_read_by_assigned_user');
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
