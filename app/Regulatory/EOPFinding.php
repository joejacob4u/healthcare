<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;

class EOPFinding extends Model
{
    protected $table = 'eop_findings';
    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany('App\Regulatory\EOPFindingComment','eop_finding_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building','building_id');
    }

    public function site()
    {
        return $this->belongsTo('App\Regulatory\Site','site_id');
    }

    public function lastAssigned()
    {
        return $this->belongsTo('App\User','last_assigned_user_id');
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
