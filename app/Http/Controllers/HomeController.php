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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        Session::put('healthsystem_id', Auth::guard('system_user')->user()->healthsystem_id);
        Session::put('healthsystem_name', Auth::guard('system_user')->user()->healthSystem->healthcare_system);

        return view('home');
    }

    public function dashboard()
    {
        $no_of_hcos = HCO::where('healthsystem_id', Auth::guard('system_user')->user()->healthsystem_id)->count();
        $no_of_users = User::where('healthsystem_id', Auth::guard('system_user')->user()->healthsystem_id)->count();
        $no_of_sites = Site::whereIn('hco_id', HCO::where('healthsystem_id', Auth::guard('system_user')->user()->healthsystem_id)->select('id')->pluck('id'))->count();
        $no_of_buildings = Building::whereIn('site_id', Site::whereIn('hco_id', HCO::where('healthsystem_id', Auth::guard('system_user')->user()->healthsystem_id)->select('id')->pluck('id'))->select('id')->pluck('id'))->count();
        $eop_findings = EOPFinding::get();

        return view('dashboard', [
            'no_of_hcos' => $no_of_hcos,
            'no_of_users' => $no_of_users,
            'no_of_sites' => $no_of_sites,
            'no_of_buildings' => $no_of_buildings
        ]);
    }

    public function logout()
    {
        $guards = array_keys(config('auth.guards'));

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }
        Session::flush();
        return redirect('/login');
    }
}
