<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundingSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounding_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('rounding_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rounding_category_id');
            $table->foreign('rounding_category_id')->references('id')->on('rounding_categories')->onDelete('cascade');
            $table->unsignedInteger('system_tier_id');
            $table->foreign('system_tier_id')->references('id')->on('system_tiers')->onDelete('cascade');
            $table->unsignedInteger('eop_id');
            $table->string('question');
            $table->string('answer_type');
            $table->string('answers');
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
        Schema::table('rounding_categories', function (Blueprint $table) {
            //
        });
    }
}
