<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEopDocumentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eop_documentation', function (Blueprint $table) {
            $table->integer('accreditation_id');
            $table->integer('eop_id');
            $table->integer('building_id');
            $table->string('document_path');
            $table->date('submission_date');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eop_documentation');
    }
}
