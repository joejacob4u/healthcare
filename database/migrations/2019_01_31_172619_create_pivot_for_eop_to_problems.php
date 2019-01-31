<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotForEopToProblems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eop_problem', function (Blueprint $table) {
            $table->unsignedInteger('eop_id');
            $table->foreign('eop_id')->references('id')->on('eop')->onDelete('cascade');
            $table->unsignedInteger('work_order_problem_id');
            $table->foreign('work_order_problem_id')->references('id')->on('work_order_problems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eop_problem');
    }
}
