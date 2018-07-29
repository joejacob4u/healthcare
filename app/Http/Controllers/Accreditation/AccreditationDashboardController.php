<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;
use App\Regulatory\Accreditation;
use App\Regulatory\EOPFinding;
use App\Regulatory\Building;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Database\Eloquent\Collection;
use App\Regulatory\EOP;

class AccreditationDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $hco = HCO::find(session('hco_id'));
        $safer_matrix = $this->calculateSaferMatrix();
        return view('accreditation.dashboard', ['hco' => $hco,'safer_matrix' => $safer_matrix]);
    }

    public function hcoFindings()
    {
        $hco = HCO::find(session('hco_id'));
        //$findings = EOPFinding::whereIn('building_id', $hco->sites->buildings->pluck('id'))->select('id', 'accreditation_id')->get();

        $datas = new Collection;
        
        foreach ($hco->accreditations as $accreditation) {
            foreach ($accreditation->accreditationRequirements as $requirement) {
                $status = DB::table('eop_findings')
                            ->select(DB::raw('count(*) as status_count, eop_findings.status'))
                            ->leftJoin('buildings', 'buildings.id', '=', 'eop_findings.building_id')
                            ->leftJoin('sites', 'sites.id', '=', 'buildings.site_id')
                            ->leftJoin('eop', 'eop.id', '=', 'eop_findings.eop_id')
                            ->whereIn('eop.standard_label_id', $requirement->standardLabels()->pluck('standard_label_id'))
                            ->where('sites.hco_id', session('hco_id'))
                            ->where('eop_findings.accreditation_id', $accreditation->id)->groupBy('status')->get();

                $pending_verification = (!is_null($status->where('status', 'pending_verification')->first())) ?  $status->where('status', 'pending_verification')->first()->status_count : 0;
                $issues_corrected_verify = (!is_null($status->where('status', 'issues_corrected_verify')->first())) ?  $status->where('status', 'issues_corrected_verify')->first()->status_count : 0;
                $initial = (!is_null($status->where('status', 'initial')->first())) ? $status->where('status', 'initial')->first()->status_count : 0;
                $non_compliant = (!is_null($status->where('status', 'non-compliant')->first())) ? $pending_verification = $status->where('status', 'non-compliant')->first()->status_count : 0;

                $datas->push([
                    'accreditation' => $accreditation->name,
                    'accreditation_standard' => $requirement->name,
                    'pending_verification' => $pending_verification,
                    'issues_corrected_verify' => $issues_corrected_verify,
                    'initial' => $initial,
                    'non_compliant' => $non_compliant
                ]);
            }
        }


        return Datatables::of($datas)
                ->addColumn('pending_verification_count', function ($data) {
                    if ($data['pending_verification'] == 0) {
                        return '<small class="label bg-green">&#10004;</small>';
                    } else {
                        return '<small class="label bg-red">'.$data['pending_verification'].'</small>';
                    }
                })
                ->addColumn('issues_corrected_verify_count', function ($data) {
                    if ($data['issues_corrected_verify'] == 0) {
                        return '<small class="label bg-green">&#10004;</small>';
                    } else {
                        return '<small class="label bg-red">'.$data['issues_corrected_verify'].'</small>';
                    }
                })
                ->addColumn('initial_count', function ($data) {
                    if ($data['initial'] == 0) {
                        return '<small class="label bg-green">&#10004;</small>';
                    } else {
                        return '<small class="label bg-red">'.$data['initial'].'</small>';
                    }
                })
                ->addColumn('non_compliant', function ($data) {
                    if ($data['non_compliant'] == 0) {
                        return '<small class="label bg-green">&#10004;</small>';
                    } else {
                        return '<small class="label bg-red">'.$data['non_compliant'].'</small>';
                    }
                })->make(true);
    }

    public function hcoDocumentsReport()
    {
        $hco = HCO::find(session('hco_id'));

        $buildings = Building::whereIn('site_id', $hco->sites->pluck('id'))->pluck('id');

        $datas = new Collection;


        
        foreach ($hco->accreditations as $accreditation) {
            foreach ($accreditation->accreditationRequirements as $requirement) {

                //$baseline_dates_set = DB::table()->where('eop_id',)->where()
                $status = DB::table('eop')
                        ->leftJoin('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
                        ->leftJoin('eop_document_baseline_dates', 'eop_document_baseline_dates.eop_id', '=', 'eop.id')
                        ->leftJoin('eop_document_submission_dates', 'eop_document_submission_dates.eop_id', '=', 'eop.id')
                        ->whereIn('standard_label.id', $requirement->standardLabels->pluck('id'))
                        ->where('eop.documentation', 1)
                        ->where('eop_document_submission_dates.accreditation_id', $accreditation->id)
                        ->where('eop_document_baseline_dates.accreditation_id', $accreditation->id)
                        ->whereIn('eop_document_submission_dates.building_id', $buildings)
                        ->select(DB::raw('count(*) as status_count, eop_document_submission_dates.status'))
                        ->groupBy('status')->get();

                $eops = DB::table('eop')->leftJoin('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')->whereIn('standard_label.id', $requirement->standardLabels->pluck('id'))->where('eop.documentation', 1)->pluck('eop.id');
                $baseline_dates = DB::table('eop_document_baseline_dates')->whereIn('eop_id', $eops)->whereIn('building_id', $buildings)->where('accreditation_id', $accreditation->id)->count();
                $missing_baseline_dates = count($eops) - $baseline_dates;



                $pending_uploads = (!is_null($status->where('status', 'pending_upload')->first())) ?  $status->where('status', 'pending_upload')->first()->status_count : 0;
                $pending_verification = (!is_null($status->where('status', 'pending_verification')->first())) ?  $status->where('status', 'pending_verification')->first()->status_count : 0;
                $compliant = (!is_null($status->where('status', 'compliant')->first())) ?  $status->where('status', 'compliant')->first()->status_count : 0;
                $non_compliant = (!is_null($status->where('status', 'non-compliant')->first())) ?  $status->where('status', 'non-compliant')->first()->status_count : 0;
                $baseline_missing_dates = $missing_baseline_dates;

                $datas->push([
                    'accreditation' => $accreditation->name,
                    'accreditation_standard' => $requirement->name,
                    'pending_upload' => $pending_uploads,
                    'pending_verification' => $pending_verification,
                    'compliant' => $compliant,
                    'non_compliant' => $non_compliant,
                    'baseline_missing_dates' => $baseline_missing_dates
                ]);
            }
        }

        return Datatables::of($datas)
        ->addColumn('baseline_missing_dates', function ($data) {
            if ($data['baseline_missing_dates'] == 0) {
                return '<small class="label bg-green">&#10004;</small>';
            } else {
                return '<small class="label bg-red">'.$data['baseline_missing_dates'].'</small>';
            }
        })
        ->addColumn('pending_upload', function ($data) {
            if ($data['pending_upload'] == 0) {
                return '<small class="label bg-green">&#10004;</small>';
            } else {
                return '<small class="label bg-red">'.$data['pending_upload'].'</small>';
            }
        })
        ->addColumn('pending_verification', function ($data) {
            if ($data['pending_verification'] == 0) {
                return '<small class="label bg-green">&#10004;</small>';
            } else {
                return '<small class="label bg-red">'.$data['pending_verification'].'</small>';
            }
        })
        ->addColumn('compliant', function ($data) {
            if ($data['compliant'] == 0) {
                return '<small class="label bg-green">&#10004;</small>';
            } else {
                return '<small class="label bg-red">'.$data['compliant'].'</small>';
            }
        })
        ->addColumn('non_compliant', function ($data) {
            if ($data['non_compliant'] == 0) {
                return '<small class="label bg-green">&#10004;</small>';
            } else {
                return '<small class="label bg-red">'.$data['non_compliant'].'</small>';
            }
        })->make(true);
    }

    public function documentsActionPlan()
    {
        $hco = HCO::find(session('hco_id'));

        $buildings = Building::whereIn('site_id', $hco->sites->pluck('id'))->pluck('id');

        $documents = DB::table('eop_document_submission_dates')
                    ->leftJoin('eop', 'eop.id', '=', 'eop_document_submission_dates.eop_id')
                    ->leftJoin('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
                    ->leftJoin('accreditation', 'accreditation.id', '=', 'eop_document_submission_dates.accreditation_id')
                    ->whereIn('eop_document_submission_dates.building_id', $buildings)
                    ->select('accreditation.name as accreditation_name', 'standard_label.label', 'eop.name as eop_name', 'eop.id', 'eop.text as eop_text', 'eop_document_submission_dates.submission_date', 'eop_document_submission_dates.status')->get();



        $eops = EOP::where('documentation', 1)->whereNotIn('eop.id', $documents->pluck('id'))->get();

        $datas = new Collection;

        $missing_baseline_dates = [];
        //$missing_baseline_buildings = $buildings->whereNotIn('eop')

        foreach ($hco->accreditations as $accreditation) {
            foreach ($accreditation->accreditationRequirements as $requirement) {
                foreach ($eops as $eop) {
                    if (isset($eop->standardLabel->label)) {
                        $datas->push([
                            'accreditation' => $accreditation->name,
                            'standard_label' => $eop->standardLabel->label,
                            'eop_number' => $eop->name,
                            'eop_text' => $eop->text,
                            'baseline_date_set' => 0,
                            'documentation_submission_date' => 'n/a',
                            'status' => 'Baseline Not Set'
                        ]);
                    }
                }
            }
        }

        foreach ($documents as $document) {
            $datas->push([
                'accreditation' => $document->accreditation_name,
                'standard_label' => $document->label,
                'eop_number' => $document->eop_name,
                'eop_text' => $document->eop_text,
                'baseline_date_set' => 1,
                'documentation_submission_date' => $document->submission_date,
                'status' => $document->status
            ]);
        }

        return Datatables::of($datas)
                ->addColumn('is_baseline_date_set', function ($data) {
                    if ($data['baseline_date_set'] == 1) {
                        return '<small class="label bg-green">&#10004;</small>';
                    } else {
                        return '<small class="label bg-red">x</small>';
                    }
                })->make(true);
    }

    private function calculateSaferMatrix()
    {
        $hco = HCO::find(session('hco_id'));

        $safer_matrix['itl'] = [];

        $safer_matrix['low_limited'] = [];
        $safer_matrix['low_pattern'] = [];
        $safer_matrix['low_widespread'] = [];

        $safer_matrix['moderate_limited'] = [];
        $safer_matrix['moderate_pattern'] = [];
        $safer_matrix['moderate_widespread'] = [];

        $safer_matrix['high_limited'] = [];
        $safer_matrix['high_pattern'] = [];
        $safer_matrix['high_widespread'] = [];

        foreach ($hco->sites as $site) {
            foreach ($site->buildings as $building) {
                $eops = $building->findings->unique('eop_id');

                foreach ($eops->values()->all() as $eop) {

                    //if itl always pass to itl array

                    if ($building->findings->where('eop_id', $eop->eop_id)->contains('potential_to_cause_harm', 'immediate_threat_to_life')) {
                        array_push($safer_matrix['itl'], $eop);
                    }

                    //figure out if low,moderate or high

                    if ($building->findings->where('eop_id', $eop->eop_id)->contains('potential_to_cause_harm', 'high')) {
                        $intensity = 'high';
                    } elseif ($building->findings->where('eop_id', $eop->eop_id)->contains('potential_to_cause_harm', 'moderate')) {
                        $intensity = 'moderate';
                    } else {
                        $intensity = 'low';
                    }

                    //figure out if its limited,pattern,or widepsread

                    if ($building->findings->where('eop_id', $eop->eop_id)->contains('is_policy_issue', 1)) {
                        $reach = 'widespread';
                    } elseif ($building->findings->where('eop_id', $eop->eop_id)->count() > 1) {
                        $reach = 'pattern';
                    } else {
                        $reach = 'limited';
                    }

                    //add it in array
                    
                    array_push($safer_matrix[$intensity.'_'.$reach], $eop);
                }
            }
        }

        return $safer_matrix;
    }

    public function documentActionPlan()
    {
        $hco = HCO::find(session('hco_id'));

        $standard_labels = [];

        foreach ($hco->accreditations as $accreditation) {
            foreach ($accreditation->accreditationRequirements as $accreditation_requirement) {
                $standard_labels []= $accreditation_requirement->standardLabels->pluck('id');
            }
        }

        $eops = DB::table('eop')
                ->leftJoin('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
                ->whereIn('standard_label.id', $standard_labels)
                ->where('eop.documentation', 1)
                ->select('eop.id')->get();
    }
}
