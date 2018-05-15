<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPDocument extends Model
{
    protected $table = 'eop_documents';

    protected $guarded = ['id'];


    public function submissionDate()
    {
        return $this->belongsTo('App\Regulatory\EOPDocumentSubmissionDate', 'eop_document_submission_date_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Regulatory\EOPDocumentComment', 'eop_document_id');
    }
}
