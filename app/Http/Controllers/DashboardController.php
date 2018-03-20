<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Regulatory\HCO;
use App\Regulatory\Site;
use App\Regulatory\Building;
use App\User;
use App\Regulatory\EOPFinding;
use Yajra\Datatables\Datatables;
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('loggedin');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no_of_hcos = HCO::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->count();
        $no_of_users = User::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->count();
        $no_of_sites = Site::whereIn('hco_id',HCO::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->select('id')->pluck('id'))->count();
        $no_of_buildings = Building::whereIn('site_id',Site::whereIn('hco_id',HCO::where('healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->select('id')->pluck('id'))->select('id')->pluck('id'))->count();
        $eop_findings = EOPFinding::get();
        
        return view('dashboard',[
            'no_of_hcos' => $no_of_hcos,
            'no_of_users' => $no_of_users,
            'no_of_sites' => $no_of_sites,
            'no_of_buildings'=> $no_of_buildings
        ]);
    }

    public function getFindings(Request $request)
    {
        $findings = DB::table('eop_findings')
                    ->join('buildings', 'buildings.id', '=', 'eop_findings.building_id')
                    ->select('eop_findings.id', 'eop_findings.description', 'eop_findings.eop_id','buildings.name','eop_findings.status')
                    ->where('eop_findings.healthsystem_id',Auth::guard('system_user')->user()->healthsystem_id)->orderBy('eop_findings.updated_at', 'desc');
        
        return Datatables::of($findings)
                ->addColumn('building',function($finding) {
                    return $finding->name;
                })
                ->addColumn('view',function($finding){
                    return '<a href="system-admin/accreditation/eop/status/'.$finding->eop_id.'/finding/'.$finding->id.'" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-eye-open"></span> View</a>';
                })
                ->removeColumn('id')
                ->removeColumn('eop_id')
                ->make(true);
    }


}
