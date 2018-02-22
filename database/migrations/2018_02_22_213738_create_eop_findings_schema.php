<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEopFindingsSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eop_findings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->integer('eop_id');
            $table->string('location');
            $table->text('status');
            $table->string('created_by_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eop_findings');
    }
}
