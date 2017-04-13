<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->integer('problem_id');
            $table->integer('status_id');
            $table->integer('category_id');
            $table->integer('priority_id');
            $table->integer('asset_id');
            $table->integer('trade_id');
            $table->string('billable_status');
            $table->string('location');
            $table->text('location_detail');
            $table->decimal('estimated_cost', 5, 2);
            $table->integer('material_po_number');
            $table->decimal('estimated_hours', 5, 2);
            $table->date('scheduled_date');
            $table->date('available_date');
            $table->date('needed_by_date');
            $table->string('requester_name');
            $table->string('requester_phone');
            $table->string('requester_email');
            $table->text('requester_comments');
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
        Schema::dropIfExists('work_orders');
    }
}
