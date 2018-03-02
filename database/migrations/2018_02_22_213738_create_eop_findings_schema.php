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
            $table->text('plan_of_action');
            $table->text('measure_of_success');
            $table->text('internal_notes');
            $table->integer('eop_id');
            $table->string('location');
            $table->text('status');
            $table->string('created_by_user_id');
            $table->timestamps();
        });

        Schema::create('eop_finding_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eop_finding_id');
            $table->text('comment');
            $table->boolean('is_important');
            $table->string('attachments_path');
            $table->string('status');
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
        Schema::dropIfExists('eop_finding_comments');
    }
}
