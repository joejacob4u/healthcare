<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;
use DB;

class AccreditationRequirement extends Model
{
    protected $table = 'accreditation_requirements';
    protected $fillable = ['name'];

    public function accreditations()
    {
        return $this->belongsToMany('App\Regulatory\Accreditation', 'accr_accr-requirement', 'accrediation-requirement_id', 'accrediation_id');
    }

    public function standardLabels()
    {
        return $this->belongsToMany('App\Regulatory\StandardLabel', 'standard-label_accrediation-requirement', 'accrediation_requirement_id', 'standard_label_id');
    }

    /**
     * countFindingByStatus - returns count of findings per status
     *
     * @param string $status - status
     * @return integer
     */
    public function countFindingByStatus($status, $accreditation_id)
    {
        return DB::table('eop_findings')
                ->leftJoin('buildings', 'buildings.id', '=', 'eop_findings.building_id')
                ->leftJoin('sites', 'sites.id', '=', 'buildings.site_id')
                ->leftJoin('eop', 'eop.id', '=', 'eop_findings.eop_id')
                ->whereIn('eop.standard_label_id', $this->standardLabels()->pluck('standard_label_id'))
                ->where('sites.hco_id', session('hco_id'))
                ->where('eop_findings.accreditation_id', $accreditation_id)
                ->where('eop_findings.status', $status)->count();
    }
}
