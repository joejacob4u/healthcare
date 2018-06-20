<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\EOP;
use App\Regulatory\EOPFinding;
use App\Regulatory\EOPFindingComment;
use App\Regulatory\EOPDocument;
use App\Regulatory\Building;
use App\Regulatory\HealthSystem;
use App\Regulatory\AccreditationRequirement;
use Yajra\Datatables\Datatables;
use App\User;
use Auth;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Regulatory\BuildingDepartment;
use Carbon\Carbon;

class EOPStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($eop_id)
    {
        $eop = EOP::find($eop_id);
        $building = Building::find(session('building_id'));
        $findings = EOPFinding::where('building_id', session('building_id'))->where('eop_id', $eop_id)->where('accreditation_id', session('accreditation_id'))->orderBy('id', 'desc')->get();
        return view('accreditation.status', ['eop' => $eop,'building' => $building,'findings' => $findings]);
    }

    public function addFinding($eop_id)
    {
        if (Input::has('document_id')) {
            $description = EOPDocument::find(Input::get('document_id'))->comments->last()->comment;
        } else {
            $description = '';
        }
        
        $eop = EOP::find($eop_id);
        $building = Building::find(session('building_id'));
        return view('accreditation.finding.add', ['eop' => $eop,'description' => $description,'building' => $building]);
    }

    public function editFinding($eop_id, $finding_id)
    {
        $finding = EOPFinding::find($finding_id);
        $eop = EOP::find($eop_id);
        $building = Building::find(session('building_id'));
        return view('accreditation.finding.edit', ['finding' => $finding,'eop' => $eop,'building' => $building]);
    }

    public function saveFinding(Request $request, $eop_id, $finding_id)
    {
        $this->validate($request, [
            'description' => 'required',
            'plan_of_action' => 'required',
            'measure_of_success' => 'required',
            'measure_of_success_date' => 'required',
            'status' => 'required',
            'benefit' => 'required',
            'activity' => 'not_in:0'
        ]);

        $finding = EOPFinding::find($finding_id);

        if ($finding->update($request->all())) {
            return redirect('system-admin/accreditation/eop/status/'.$request->eop_id)->with('success', 'Finding saved!');
        }
    }

    public function createFinding(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'plan_of_action' => 'required',
            'measure_of_success' => 'required',
            'status' => 'required',
            'benefit' => 'required',
            'activity' => 'not_in:0',
            'room_id' => 'not_in:0',
            'department_id' => 'not_in:0'

        ]);

        if (EOPFinding::create($request->all())) {
            return redirect('system-admin/accreditation/eop/status/'.$request->eop_id)->with('success', 'New finding added!');
        }
    }

    public function viewFinding($eop_id, $finding_id)
    {
        $eop = EOP::find($eop_id);
        $finding = EOPFinding::find($finding_id);
        $this->changeSession($finding);
        $building = Building::find($finding->building_id);
        $healthsystem_users = User::where('healthsystem_id', Auth::guard('system_user')->user()->healthsystem_id)->pluck('name', 'id')->prepend('Please select a user', '0');
        return view('accreditation.finding.finding', ['eop' => $eop,'building' => $building,'finding' => $finding,'healthsystem_users' => $healthsystem_users]);
    }

    public function createComment(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'comment' => 'required',
            'due_date' => 'required_unless:status,compliant',
            'assigned_user_id' => 'required_unless:status,compliant'
        ]);

        $finding = EOPFinding::find($request->eop_finding_id);

        if (EOPFindingComment::create($request->all())) {
            $finding->update(['status' => $request->status,'last_assigned_user_id' => (!empty($request->assigned_user_id)) ? $request->assigned_user_id : '']);
            return back()->with('success', 'Comment has been added!');
        }
    }

    public function getFindingsByUser(Request $request)
    {
        $findings = EOPFindingComment::where('assigned_user_id', Auth::guard('system_user')->user()->id)
                                        ->where('is_read_by_assigned_user', 0)->latest()->limit($request->limit)->get();
    }

    public function changeSession($finding)
    {
        Session::put('building_id', $finding->building_id);
        $building = Building::find($finding->building_id);
        Session::put('site_id', $building->site_id);
        Session::put('hco_id', $building->site->hco_id);
        Session::put('hco_name', $building->site->hco->facility_name);
        Session::put('building_name', $building->name);
        Session::put('site_name', $building->site->name);
        //Session::put('hco_name', $building->site->hco->name);
    }

    public function actionPlanIndex()
    {
        $hco = HCO::find(session('hco_id'));
        return view('accreditation.action_plan', ['hco' => $hco]);
    }

    public function getActionPlan()
    {
        $findings = DB::table('eop_findings')
        ->join('buildings', 'buildings.id', '=', 'eop_findings.building_id')
        ->join('sites', 'sites.id', '=', 'buildings.site_id')
        ->join('hco', 'hco.id', '=', 'sites.hco_id')
        ->join('healthsystem', 'healthsystem.id', '=', 'hco.healthsystem_id')
        ->join('eop', 'eop.id', '=', 'eop_findings.eop_id')
        ->join('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
        ->leftJoin('users', 'users.id', '=', 'eop_findings.last_assigned_user_id')
        ->select('eop_findings.id', 'eop_findings.description', 'eop_findings.eop_id', 'buildings.name as building_name', 'buildings.building_id', 'eop_findings.status', 'healthsystem.healthcare_system', 'hco.facility_name', 'sites.name as site_name', 'sites.site_id as site_id', 'eop_findings.measure_of_success', 'eop_findings.benefit', 'eop_findings.plan_of_action', 'users.name as last_assigned_name', 'eop_findings.measure_of_success_date as due_date', 'eop.name as eop_name', 'eop.text as eop_text', 'standard_label.label', 'standard_label.text as label_text', 'eop_findings.created_at')
        ->where('healthsystem.id', Auth::user()->healthsystem_id)
        ->where('hco.id', session('hco_id'))
        ->orderBy('eop_findings.updated_at', 'desc');

        return Datatables::of($findings)
            ->addColumn('site_name', function ($finding) {
                return $finding->site_name.'(#'.$finding->site_id.')';
            })
            ->addColumn('building_name', function ($finding) {
                return $finding->building_name.'(#'.$finding->building_id.')';
            })
            ->addColumn('last_assigned_name', function ($finding) {
                return (!empty($finding->last_assigned_name)) ? $finding->last_assigned_name : 'TBD';
            })
            ->addColumn('status', function ($finding) {
                return ucwords(implode(' ', explode('_', $finding->status)));
            })
            ->addColumn('eop_name', function ($finding) {
                return $finding->eop_name;
            })
            ->addColumn('eop_text', function ($finding) {
                return '<a href="#" data-toggle="popover" data-trigger="hover" data-container="body" title="EOP Text" data-content="'.$finding->eop_text.'">'.substr($finding->eop_text, 0, 50).'...</a>';
            })
            ->addColumn('label', function ($finding) {
                return $finding->label;
            })
            ->addColumn('label_text', function ($finding) {
                return $finding->label_text;
            })
            ->addColumn('finding_button', function ($finding) {
                return '<a href="/system-admin/accreditation/eop/status/'.$finding->eop_id.'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-info-sign"></span> Finding</a>';
            })
            ->addColumn('finding_date', function ($finding) {
                return Carbon::parse($finding->created_at)->toFormattedDateString();
            })


            ->removeColumn('id')
            ->removeColumn('eop_id')
            ->make(true);
    }

    public function exportToCSV()
    {
        $findings = DB::table('eop_findings')
            ->join('buildings', 'buildings.id', '=', 'eop_findings.building_id')
            ->join('sites', 'sites.id', '=', 'buildings.site_id')
            ->join('hco', 'hco.id', '=', 'sites.hco_id')
            ->join('healthsystem', 'healthsystem.id', '=', 'hco.healthsystem_id')
            ->join('eop', 'eop.id', '=', 'eop_findings.eop_id')
            ->join('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
            ->leftJoin('users', 'users.id', '=', 'eop_findings.last_assigned_user_id')
            ->select('healthsystem.healthcare_system', 'hco.facility_name', 'hco.hco_id', 'sites.name as site_name', 'sites.site_id', 'sites.address', 'buildings.name as building_name', 'buildings.building_id', 'standard_label.label', 'standard_label.text as label_text', 'eop.name as eop_name', 'eop.text as eop_text', 'eop_findings.description', 'eop_findings.created_at', 'eop_findings.measure_of_success', 'eop_findings.benefit', 'eop_findings.plan_of_action', 'users.name as last_assigned_name', 'eop_findings.measure_of_success_date as due_date', 'eop_findings.status', 'standard_label.label', 'standard_label.text as label_text')
            ->where('healthsystem.id', Auth::guard('system_user')->user()->healthsystem_id)
            ->orderBy('eop_findings.updated_at', 'desc')->get();


        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne([
                'Healthcare System',
                'HCO',
                'HCO ID#',
                'Site',
                'Site#',
                'Site Address',
                'Building',
                'Building#',
                'Standard Label',
                'Standard Label Text',
                'EOP Name',
                'EOP Text',
                'Finding',
                'Finding Created At',
                'Measure of Success',
                'Benefit',
                'Plan of Action',
                'Last Assigned To',
                'Due Date',
                'Status'
            ]);

        foreach (json_decode(json_encode($findings), true) as $finding) {
            $csv->insertOne($finding);
        }

        $csv->output('action_sheet_healthsystem_'.date('Y-m-d:H:i:s').'.csv');
        exit;
    }

    public function exportHCOToCSV()
    {
        $findings = DB::table('eop_findings')
            ->join('buildings', 'buildings.id', '=', 'eop_findings.building_id')
            ->join('sites', 'sites.id', '=', 'buildings.site_id')
            ->join('hco', 'hco.id', '=', 'sites.hco_id')
            ->join('healthsystem', 'healthsystem.id', '=', 'hco.healthsystem_id')
            ->join('eop', 'eop.id', '=', 'eop_findings.eop_id')
            ->join('standard_label', 'standard_label.id', '=', 'eop.standard_label_id')
            ->leftJoin('users', 'users.id', '=', 'eop_findings.last_assigned_user_id')
            ->select('healthsystem.healthcare_system', 'hco.facility_name', 'hco.hco_id', 'sites.name as site_name', 'sites.site_id', 'sites.address', 'buildings.name as building_name', 'buildings.building_id', 'standard_label.label', 'standard_label.text as label_text', 'eop.name as eop_name', 'eop.text as eop_text', 'eop_findings.description', 'eop_findings.measure_of_success', 'eop_findings.benefit', 'eop_findings.plan_of_action', 'users.name as last_assigned_name', 'eop_findings.measure_of_success_date as due_date', 'eop_findings.status', 'standard_label.label', 'standard_label.text as label_text')
            ->where('healthsystem.id', Auth::guard('system_user')->user()->healthsystem_id)
            ->where('hco.id', session('hco_id'))
            ->orderBy('eop_findings.updated_at', 'desc')->get();


        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne([
            'Healthcare System',
            'HCO',
            'HCO ID#',
            'Site',
            'Site#',
            'Site Address',
            'Building',
            'Building#',
            'Standard Label',
            'Standard Label Text',
            'EOP Name',
            'EOP Text',
            'Finding',
            'Measure of Success',
            'Benefit',
            'Plan of Action',
            'Last Assigned To',
            'Due Date',
            'Status'
        ]);

        foreach (json_decode(json_encode($findings), true) as $finding) {
            $csv->insertOne($finding);
        }

        $csv->output('action_sheet_'.$findings->first()->facility_name.'_'.date('Y-m-d:H:i:s').'.csv');
        exit;
    }

    public function fetchRooms(Request $request)
    {
        $department = BuildingDepartment::find($request->department_id);
        return response()->json(['rooms' => $department->rooms]);
    }
}
