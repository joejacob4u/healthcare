<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\TJCChecklistEOP;
use App\Regulatory\EOP;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class TJCChecklistEOPController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $tjc_checklist_eops = TJCChecklistEOP::where('healthsystem_id', session('healthsystem_id'))->get();
        $standard_labels = StandardLabel::get();
        return view('tjc.eop.index', ['tjc_checklist_eops' => $tjc_checklist_eops,'standard_labels' => $standard_labels]);
    }

    public function fetchStandardLabels(Request $request)
    {
        $standard_labels = StandardLabel::select('id', 'label')->where("label", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($standard_labels);
    }


    public function fetchChecklistEOPS(Request $request)
    {
        $checklist_eops = DB::table('tjc_checklist_eops')
                        ->join('eop', 'eop.id', '=', 'tjc_checklist_eops.eop_id')
                        ->join('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
                        ->select('tjc_checklist_eops.id', 'eop.name as eop_name', 'standard_label.label as standard_label', 'eop.text as eop_text')
                        ->where('healthsystem_id', Auth::user()->healthsystem_id);

        return Datatables::of($checklist_eops)
                ->addColumn('eop_name', function ($checklist_eop) {
                    return $checklist_eop->eop_name;
                })
                ->addColumn('standard_label', function ($checklist_eop) {
                    return $checklist_eop->standard_label;
                })
                ->addColumn('remove_eop', function ($checklist_eop) {
                    return '<a onclick="removeFromChecklist('.$checklist_eop->id.')" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Remove from Checklist</a>';
                })->addColumn('eop_text', function ($checklist_eop) {
                    return '<a href="#" data-toggle="popover" data-trigger="hover" data-container="body" title="EOP Text" data-content="'.$checklist_eop->eop_text.'">'.substr($checklist_eop->eop_text, 0, 150).'...</a>';
                })->setRowId('id')->make(true);
    }

    public function fetchAvailableEOPS()
    {
        $available_eops = DB::table('eop')
                        ->join('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
                        ->select('eop.id', 'eop.name as eop_name', 'standard_label.label as standard_label', 'eop.text as eop_text')
                        ->whereNotIn('eop.id', TJCChecklistEOP::pluck('eop_id'))
                        ->where('standard_label.accreditation_id', 1);

        return Datatables::of($available_eops)
                ->addColumn('eop_name', function ($available_eop) {
                    return $available_eop->eop_name;
                })
                ->addColumn('standard_label', function ($available_eop) {
                    return $available_eop->standard_label;
                })
                ->addColumn('add_eop', function ($available_eop) {
                    return '<a onclick="addToChecklist('.$available_eop->id.')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Add to Checklist</a>';
                })
                ->addColumn('eop_text', function ($available_eop) {
                    return '<a href="#" data-toggle="popover" data-trigger="hover" data-container="body" title="EOP Text" data-content="'.$available_eop->eop_text.'">'.substr($available_eop->eop_text, 0, 150).'...</a>';
                })->setRowId('id')->make(true);
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        if (TJCChecklistEOP::create(['eop_id' => $request->eop_id,'healthsystem_id' => Auth::user()->healthsystem_id])) {
            return 'true';
        }
    }

    public function delete(Request $request)
    {
        if (TJCChecklistEOP::destroy($request->tjc_checklist_id)) {
            return 'true';
        }
    }
}
