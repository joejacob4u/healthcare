<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\EOP;
use App\Regulatory\EOPFinding;
use App\Regulatory\EOPFindingComment;
use App\Regulatory\Building;
use App\Regulatory\HealthSystem;
use App\Regulatory\AccreditationRequirement;
use Yajra\Datatables\Datatables;
use App\User;
use Auth;
use Session;
use DB;

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
        $findings = EOPFinding::orderBy('id','desc')->get();
        return view('accreditation.status',['eop' => $eop,'building' => $building,'findings' => $findings]);
    }

    public function addFinding($eop_id)
    {
        $eop = EOP::find($eop_id);
        return view('accreditation.finding.add',['eop' => $eop]);
    }

    public function editFinding($eop_id,$finding_id)
    {
        $finding = EOPFinding::find($finding_id);
        $eop = EOP::find($eop_id);
        return view('accreditation.finding.edit',['finding' => $finding,'eop' => $eop]);
    }

    public function saveFinding(Request $request,$eop_id,$finding_id)
    {
        $this->validate($request,[
            'description' => 'required',
            'plan_of_action' => 'required',
            'measure_of_success' => 'required',
            'measure_of_success_date' => 'required',
            'status' => 'required',
            'location' => 'required',
            'benefit' => 'required',
            'activity' => 'not_in:0'
        ]);

        $finding = EOPFinding::find($finding_id);

        if($finding->update($request->all()))
        {
            return redirect('system-admin/accreditation/eop/status/'.$request->eop_id)->with('success','Finding saved!');
        }

    }

    public function createFinding(Request $request)
    {
        $this->validate($request,[
            'description' => 'required',
            'plan_of_action' => 'required',
            'measure_of_success' => 'required',
            'status' => 'required',
            'location' => 'required',
            'benefit' => 'required',
            'activity' => 'not_in:0'

        ]);

        if(EOPFinding::create($request->all()))
        {
            return redirect('system-admin/accreditation/eop/status/'.$request->eop_id)->with('success','New finding added!');
        }
    }

    public function viewFinding($eop_id,$finding_id)
    {
        $eop = EOP::find($eop_id);
        $finding = EOPFinding::find($finding_id);
        $this->changeSession($finding);
        $building = Building::find($finding->building_id);
        $healthsystem_users = User::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->pluck('name','id')->prepend('Please select a user', '0');
        return view('accreditation.finding.finding',['eop' => $eop,'building' => $building,'finding' => $finding,'healthsystem_users' => $healthsystem_users]);
    }

    public function createComment(Request $request)
    {
        $this->validate($request,[
            'status' => 'required',
            'comment' => 'required',
            'due_date' => 'required_if:status,!=,compliant',
            'assigned_user_id' => 'required_if:status,!=,compliant'
        ]);

        $finding = EOPFinding::find($request->eop_finding_id);

        if(EOPFindingComment::create($request->all()))
        {
            $finding->update(['status' => $request->status,'last_assigned_user_id' => (!empty($request->assigned_user_id)) ? $request->assigned_user_id : '']);
            return back()->with('success','Comment has been added!');
        }
    }

    public function getFindingsByUser(Request $request)
    {
        $findings = EOPFindingComment::where('assigned_user_id',Auth::guard('system_user')->user()->id)
                                        ->where('is_read_by_assigned_user',0)->latest()->limit($request->limit)->get();
    }

    public function changeSession($finding)
    {
        Session::put('building_id', $finding->building_id);
        $building = Building::find($finding->building_id);
        Session::put('site_id', $building->site_id);
        Session::put('hco_id', $building->site->hco_id);
        Session::put('building_name', $building->name);
        Session::put('site_name', $building->site->name);
        //Session::put('hco_name', $building->site->hco->name);
    }

    public function actionPlanIndex()
    {
        return view('accreditation.action_plan');
    }

    public function getActionPlan()
    {
        $findings = DB::table('eop_findings')
        ->join('buildings', 'buildings.id', '=', 'eop_findings.building_id')
        ->join('sites', 'sites.id', '=', 'buildings.site_id')
        ->join('hco', 'hco.id', '=', 'sites.hco_id')
        ->join('healthsystem', 'healthsystem.id', '=', 'hco.healthsystem_id')
        ->join('users', 'users.id', '=', 'eop_findings.last_assigned_user_id')
        ->select('eop_findings.id', 'eop_findings.description', 'eop_findings.eop_id','buildings.name as building_name','eop_findings.status','healthsystem.healthcare_system','hco.facility_name','sites.name as site_name','eop_findings.measure_of_success','eop_findings.benefit','eop_findings.plan_of_action','users.name as last_assigned_name','eop_findings.measure_of_success_date as due_date')
        ->where('eop_findings.healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->orderBy('eop_findings.updated_at', 'desc');

        return Datatables::of($findings)
            ->addColumn('healthcare_system',function($finding) {
                return $finding->healthcare_system;
            })
            ->addColumn('hco',function($finding){
                return $finding->facility_name;
            })
            ->addColumn('site',function($finding){
                return $finding->facility_name;
            })
            ->addColumn('measure_of_success',function($finding){
                return $finding->measure_of_success;
            })
            ->addColumn('benefit',function($finding){
                return $finding->benefit;
            })
            ->addColumn('plan_of_action',function($finding){
                return $finding->plan_of_action;
            })
            ->addColumn('last_assigned_name',function($finding){
                return $finding->last_assigned_name;
            })
            ->addColumn('due_date',function($finding){
                return $finding->due_date;
            })
            ->addColumn('status',function($finding){
                return $finding->status;
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
                    ->join('users', 'users.id', '=', 'eop_findings.last_assigned_user_id')
                    ->select('healthsystem.healthcare_system','hco.facility_name','sites.name as site_name','buildings.name as building_name','eop_findings.description','eop_findings.measure_of_success','eop_findings.benefit','eop_findings.plan_of_action','users.name as last_assigned_name','eop_findings.measure_of_success_date as due_date','eop_findings.status')
                    ->where('eop_findings.healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->orderBy('eop_findings.updated_at', 'desc')->get();

                    //dd($findings);


        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne([
                'Healthcare System',
                'HCO',
                'Site',
                'Building',
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

        $csv->output('action_sheet_'.strtotime('now').'.csv');
        exit;
    }
}
