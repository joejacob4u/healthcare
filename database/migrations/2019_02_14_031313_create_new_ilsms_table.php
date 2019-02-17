<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewIlsmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilsms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->text('description');
            $table->timestamps();
        });

        Schema::table('demand_work_orders', function (Blueprint $table) {
            $table->boolean('is_ilsm_probable')->after('is_islm')->default(0);
            $table->renameColumn('is_islm', 'is_ilsm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ilsms');
    }
}
