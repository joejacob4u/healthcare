<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEopDocumentsSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eop_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eop_id');
            $table->integer('building_id');
            $table->string('document_path');
            $table->date('submission_date');
            $table->date('upload_date');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('eop_documents-building', function (Blueprint $table) {
            $table->integer('document_id');
            $table->integer('building_id');
        });

        Schema::drop('eop_documentation');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eop_documents');
        Schema::dropIfExists('eop_documents-building');
    }
}
