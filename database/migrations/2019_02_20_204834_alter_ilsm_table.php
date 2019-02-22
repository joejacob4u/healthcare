<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIlsmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ilsms', function (Blueprint $table) {
            $table->string('frequency')->after('description')->default('one-time');
            $table->boolean('attachment_required')->after('frequency')->default(0);
        });

        Schema::create('ilsm_checklist_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ilsm_id');
            $table->foreign('ilsm_id')->references('id')->on('ilsms')->onDelete('cascade');
            $table->string('question')->nullable();
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
        Schema::table('ilsms', function (Blueprint $table) {
            //
        });
    }
}
