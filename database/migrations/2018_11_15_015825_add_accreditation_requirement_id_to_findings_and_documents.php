<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccreditationRequirementIdToFindingsAndDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eop_findings', function (Blueprint $table) {
            $table->unsignedInteger('accreditation_requirement_id')->after('accreditation_id');
        });

        Schema::table('eop_document_submission_dates', function (Blueprint $table) {
            $table->unsignedInteger('accreditation_requirement_id')->after('accreditation_id');
        });

        Schema::table('eop_document_baseline_dates', function (Blueprint $table) {
            $table->unsignedInteger('accreditation_requirement_id')->after('eop_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eop_findings', function (Blueprint $table) {
            //
        });
    }
}
