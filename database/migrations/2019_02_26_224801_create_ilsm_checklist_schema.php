<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIlsmChecklistSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilsm_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ilsm_assessment_id');
            $table->foreign('ilsm_assessment_id')->references('id')->on('ilsm_assessments')->onDelete('cascade');
            $table->unsignedInteger('ilsm_id');
            $table->foreign('ilsm_id')->references('id')->on('ilsms')->onDelete('cascade');
            $table->text('answers');
            $table->string('date');
            $table->boolean('is_answered')->default(0);
            $table->boolean('is_compliant')->default(0);
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
        Schema::dropIfExists('ilsm_checklists');
    }
}
