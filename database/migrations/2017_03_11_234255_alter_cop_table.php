<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cop', function (Blueprint $table) {
            $table->renameColumn('section', 'label');
            $table->renameColumn('section_title', 'title');
            $table->boolean('compliant');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cop', function (Blueprint $table) {
            //
        });
    }
}
