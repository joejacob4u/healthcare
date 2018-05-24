<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToEopDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop_documents', function (Blueprint $table) {
            $table->integer('eop_document_submission_date_id')->unsigned()->change();
            $table->foreign('eop_document_submission_date_id')->references('id')->on('eop_document_submission_dates')->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eop_documents', function (Blueprint $table) {
            //
        });
    }
}
