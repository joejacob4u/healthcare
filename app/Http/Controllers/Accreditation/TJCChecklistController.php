<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\TJCChecklistEOP;
use DB;
use Auth;
use App\Regulatory\TJCChecklist;
use Yajra\Datatables\Datatables;
use App\Regulatory\TJCChecklistStatus;

class TJCChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        session('accreditation_id', 1);
        
        return view('tjc.index', [
            'tjc_checklists' => TJCChecklist::latest()->where('building_id', session('building_id'))->get(),
            'tjc_checklist_eops' => TJCChecklistEOP::where('healthsystem_id', Auth::user()->healthsystem_id)->get(),
        ]);
    }

    public function available()
    {
        $available_eops = DB::table('tjc_checklist_eops')
                        ->join('eop', 'eop.id', '=', 'tjc_checklist_eops.eop_id')
                        ->join('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
                        ->select('tjc_checklist_eops.id', 'eop.name as eop_name', 'standard_label.label as standard_label', 'eop.text as eop_text')
                        ->where('healthsystem_id', Auth::user()->healthsystem_id)->where('standard_label.accreditation_id', 1)
                        ->whereNotIn('tjc_checklist_eops.id', TJCChecklist::where('user_id', Auth::user()->id)->pluck('tjc_checklist_eop_id'));

        return Datatables::of($available_eops)
                ->addColumn('eop_name', function ($available_eop) {
                    return $available_eop->eop_name;
                })
                ->addColumn('standard_label', function ($available_eop) {
                    return $available_eop->standard_label;
                })
                ->addColumn('initiate_checklist', function ($available_eop) {
                    return '<a onclick="initiateChecklist('.$available_eop->id.')" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Initiate Checklist</a>';
                })->addColumn('eop_text', function ($available_eop) {
                    return '<a href="#" data-toggle="popover" data-trigger="hover" data-container="body" title="EOP Text" data-content="'.$available_eop->eop_text.'">'.substr($available_eop->eop_text, 0, 150).'...</a>';
                })->setRowId('id')->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'surveyor_name' => 'required',
            'surveyor_email' => 'required',
            'surveyor_phone' => 'required',
            'surveyor_organization' => 'required',
            'activity' => 'required'
        ]);

        if ($tjc_checklist = TJCChecklist::create($request->all())) {
            $tjc_eops = TJCChecklistEOP::where('healthsystem_id', Auth::user()->healthsystem_id)->get();
            
            foreach ($tjc_eops as $tjc_eop) {
                TJCChecklistStatus::create([
                    'tjc_checklist_id' => $tjc_checklist->id,
                    'tjc_checklist_eop_id' => $tjc_eop->id,
                    'is_in_policy' => 'n/a',
                    'is_implemented_as_required' => 'n/a'
                ]);
            }
            return back()->with('success', 'TJC Checklist added to your checklists');
        }
    }

    public function added()
    {
        $added_eops = DB::table('tjc_checklists')
                            ->join('tjc_checklist_eops', 'tjc_checklist_eops.id', '=', 'tjc_checklists.tjc_checklist_eop_id')
                            ->join('eop', 'eop.id', '=', 'tjc_checklist_eops.eop_id')
                            ->join('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
                            ->select('tjc_checklists.id', 'eop.text as eop_text', 'tjc_checklists.surveyor_name', 'tjc_checklists.surveyor_email', 'tjc_checklists.surveyor_phone', 'tjc_checklists.surveyor_organization', 'tjc_checklists.is_in_policy', 'tjc_checklists.is_implemented_as_required', 'tjc_checklists.eoc_ls_status')
                            ->where('tjc_checklists.user_id', Auth::user()->id);

        return Datatables::of($added_eops)
                ->addColumn('eop_text', function ($added_eop) {
                    return '<a href="#" data-toggle="popover" data-trigger="hover" data-container="body" title="EOP Text" data-content="'.$added_eop->eop_text.'">'.substr($added_eop->eop_text, 0, 100).'...</a>';
                })
                ->addColumn('surveyor_name', function ($added_eop) {
                    return $added_eop->surveyor_name;
                })
                ->addColumn('surveyor_email', function ($added_eop) {
                    return $added_eop->surveyor_email;
                })
                ->addColumn('surveyor_phone', function ($added_eop) {
                    return $added_eop->surveyor_phone;
                })
                ->addColumn('surveyor_organization', function ($added_eop) {
                    return $added_eop->surveyor_organization;
                })
                ->addColumn('is_in_policy', function ($added_eop) {
                    return $added_eop->is_in_policy;
                })
                ->addColumn('is_implemented_as_required', function ($added_eop) {
                    return $added_eop->is_implemented_as_required;
                })
                ->addColumn('eoc_ls_status', function ($added_eop) {
                    return $added_eop->eoc_ls_status;
                })
                ->addColumn('edit_checklist', function ($available_eop) {
                    return '<a onclick="editChecklist('.$available_eop->id.')" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit Checklist</a>';
                })->setRowId('id')->make(true);
    }

    public function update(Request $request)
    {
        $tjc_checklist_status = TJCChecklistStatus::find($request->tjc_checklist_status_id);

        
        if ($tjc_checklist_status->update([$request->field => $request->value ])) {
            $tjc_checklist_snapshot = $tjc_checklist_status->tjcChecklist->tjcChecklistStatusStatusesSnapshot();
            
            return response()->json([
                'status' => 'success',
                'snapshot' => $tjc_checklist_snapshot,
                'tjc_checklist_id' => $tjc_checklist_status->tjcChecklist->id
            ]);
        }
    }

    public function delete(Request $request)
    {
        if (TJCChecklist::destroy($request->tjc_checklist_id)) {
            return 'true';
        }
    }
}
