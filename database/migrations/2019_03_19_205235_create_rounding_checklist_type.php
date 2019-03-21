<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRoundingChecklistType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounding_checklist_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rounding_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::table('rounding_categories', function (Blueprint $table) {
            $table->unsignedInteger('checklist_type_id')->after('name');
            $table->foreign('checklist_type_id')->references('id')->on('rounding_checklist_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rounding_checklist_types');
    }
}
