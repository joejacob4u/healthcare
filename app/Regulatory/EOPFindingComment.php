<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public function assignedBy()
    {
        return $this->belongsTo('App\User','created_by_user_id');
    }

    public function building()
    {
        return collect(DB::table('eop_findings')->select('buildings.name')
                ->leftJoin('eop_finding_comments','eop_findings.id','=','eop_finding_comments.eop_finding_id')
                ->leftJoin('buildings','eop_findings.building_id','=','buildings.id')
                ->where('eop_finding_comments.id',$this->id)->first());
    }
}
