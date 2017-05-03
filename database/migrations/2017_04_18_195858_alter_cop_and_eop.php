<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCopAndEop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop', function (Blueprint $table) {
          $table->dropColumn('frequency');
          //$table->enum('frequency', ['daily', 'weekly', 'monthly', 'quarterly', 'semi-annually', 'annually', 'two-years', 'three-years', 'four-years', 'five-years', 'six-years'])->change();
        });

        Schema::table('eop', function (Blueprint $table) {
          //$table->dropColumn('frequency');
          $table->enum('frequency', ['daily', 'weekly', 'monthly', 'quarterly', 'semi-annually', 'annually', 'two-years', 'three-years', 'four-years', 'five-years', 'six-years'])->after('documentation');
        });


        Schema::drop('accreditation_sub-cop');

        Schema::create('eop_sub-cop', function (Blueprint $table) {
          $table->integer('eop_id')->unsigned()->nullable();
          $table->foreign('eop_id','accr_id')->references('id')
                ->on('eop')->onDelete('cascade');

          $table->integer('sub_cop_id')->unsigned()->nullable();
          $table->foreign('sub_cop_id')->references('id')
                ->on('sub_cop')->onDelete('cascade');

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
        });
    }
}
