<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TjcChecklistAlters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tjc_checklists', function (Blueprint $table) {
            $table->dropForeign(['tjc_checklist_eop_id']);
            $table->dropColumn('tjc_checklist_eop_id');
            $table->dropColumn('is_in_policy');
            $table->dropColumn('is_implemented_as_required');
            $table->dropColumn('eoc_ls_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tjc_checklists', function (Blueprint $table) {
            //
        });
    }
}
