<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;
use App\Regulatory\Accreditation;

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
