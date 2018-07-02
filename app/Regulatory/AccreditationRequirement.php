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

    /**
     * countDocumentsByStatus
     *
     * @param mixed $status
     * @param mixed $accreditation_id
     * @return void
     */
    public function countDocumentsByStatus($status, $accreditation_id)
    {
        return DB::table('eop_documents')
                ->leftJoin('eop_document_submission_dates', 'eop_document_submission_dates.id', '=', 'eop_documents.eop_document_submission_date_id')
                ->leftJoin('buildings', 'buildings.id', '=', 'eop_document_submission_dates.building_id')
                ->leftJoin('sites', 'sites.id', '=', 'buildings.site_id')
                ->leftJoin('eop', 'eop.id', '=', 'eop_document_submission_dates.eop_id')
                ->whereIn('eop.standard_label_id', $this->standardLabels()->pluck('standard_label_id'))
                ->where('sites.hco_id', session('hco_id'))
                ->where('eop_document_submission_dates.accreditation_id', $accreditation_id)
                ->where('eop_document_submission_dates.status', $status)->count();
    }

    public function countDocumentsRequired()
    {
        $count = 0;

        foreach ($this->standardLabels as $standard_label) {
            foreach ($standard_label->eops as $eop) {
                if (!empty($eop->getDocumentBaseLineDate(session('building_id'))) && !$eop->getDocumentBaseLineDate(session('building_id'))->is_baseline_disabled) {
                    $count += count($eop->calculateDocumentDates($eop->getDocumentBaseLineDate(session('building_id'))->baseline_date));
                }
            }
        }
    }

    public function fetchMissingDocumentBaselineDatesByHCO($accreditation_id)
    {
        $hco = HCO::find(session('hco_id'));

        $missing_eops = [];

        $documentation_baseline_dates = DB::table('documentation_baseline_dates')->where('accreditation_id', $accreditation_id)->get();

        foreach ($hco->sites as $site) {
            foreach ($site->buildings as $building) {
                foreach ($this->standardLabels as $standard_label) {
                    foreach ($standard_label->eops as $eop) {
                        if ($documentation_baseline_dates->where('eop_id', $eop->id)->where('building_id', $building->id)->take(1)->count() < 1) {
                            array_push($missing_eops, [$building->id => $eop->id]);
                        }
                    }
                }
            }
        }

        return $missing_eops;
    }

    public function fetchMissingSubmittedDocuments($accreditation_id)
    {
        $hco = HCO::find(session('hco_id'));

        $missing_documents = [];

        $documentation_baseline_dates = DB::table('documentation_baseline_dates')->where('accreditation_id', $accreditation_id)->get();
        $eop_document_submission_dates = DB::table('eop_document_submission_dates')->where('accreditation_id', $accreditation_id)->get();

        foreach ($hco->sites as $site) {
            foreach ($site->buildings as $building) {
                foreach ($this->standardLabels as $standard_label) {
                    foreach ($standard_label->eops as $eop) {
                        $baseline_date = $documentation_baseline_dates->where('eop_id', $eop->id)->where('building_id', $building->id)->first();
                        
                        if ($baseline_date) {
                            foreach ($eop->calculateDocumentDates($baseline_date->baseline_date, true) as $date) {
                                if ($eop_document_submission_dates->where('eop_id', $eop->id)->where('building_id', $building->id)->where('submission_date', $date)->where('status', '=', 'pending_upload')->count() > 0) {
                                    array_push($missing_documents, [$building->id => $eop->id]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $missing_documents;
    }
}
