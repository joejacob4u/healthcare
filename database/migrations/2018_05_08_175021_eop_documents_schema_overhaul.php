<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EopDocumentsSchemaOverhaul extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eop_document_submission_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eop_id');
            $table->integer('building_id');
            $table->date('submission_date');
            $table->string('status');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::drop('eop_documents');

        Schema::create('eop_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eop_document_submission_date_id');
            $table->date('document_date');
            $table->date('upload_date');
            $table->string('document_path');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('eop_document_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eop_document_id');
            $table->text('comment');
            $table->integer('commented_by_user_id');
            $table->timestamps();
        });

        Schema::drop('eop_documents-building');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eop_document_submission_dates');
    }
}
