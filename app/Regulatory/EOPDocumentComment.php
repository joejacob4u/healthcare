<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPDocumentComment extends Model
{
    protected $table = 'eop_document_comments';

    protected $guarded = ['id'];

    public function document()
    {
        return $this->belongsTo('App\Regulatory\EOPDocument','eop_document_id');
    }
}
