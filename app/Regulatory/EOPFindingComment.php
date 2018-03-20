<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPFindingComment extends Model
{
    protected $table = 'eop_finding_comments';
    protected $guarded = ['id'];

    public function finding()
    {
        return $this->belongsTo('App\Regulatory\EOPFinding','eop_finding_id');
    }

    public function statusColor()
    {
        switch($this->status)
        {
            case 'initial':
                return 'danger';
                break;

            case 'non-complaint':
                return 'danger';
                break;

            case 'complaint':
                return 'success';
                break;

            case 'pending_verification':
                return 'warning';
                break;

            case 'issues_corrected_verify':
                return 'warning';
                break;

            default:
                return 'primary';
                break;

        }
    }
}
