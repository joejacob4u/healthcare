<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIslmColsToIlsm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        
        Schema::table('eop', function (Blueprint $table) {
            $table->renameColumn('is_islm', 'is_ilsm');
            $table->renameColumn('is_islm_shift', 'is_ilsm_shift');
            $table->renameColumn('islm_hours_threshold', 'ilsm_hours_threshold');
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
