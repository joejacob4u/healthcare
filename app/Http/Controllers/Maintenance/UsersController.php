<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Regulatory\HealthSystem;
use Mail;
use App\Regulatory\HCO;
use App\Regulatory\Building;
use App\Regulatory\BuildingDepartment;
use App\Regulatory\Site;
use Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_admin');
    }

    public function index()
    {
        $users = User::where('healthsystem_id', Auth::user()->healthsystem_id)->where('role_id', 5)->get();
        return view('maintenance.users.index', ['users' => $users]);
    }

    public function add()
    {
        $healthsystem = HealthSystem::find(Auth::user()->healthsystem_id);
        return view('maintenance.users.add', ['healthsystem' => $healthsystem]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'maintenance_building_id' => 'required|array|exists:buildings,id'

        ]);

        $password = str_random(8);

        $request->request->add(['password' => Hash::make($password)]);
        $request->request->add(['healthsystem_id' => Auth::user()->healthsystem_id]);


        if ($user = User::create($request->all())) {
            $user->buildings()->sync($request->maintenance_building_id);
            $user->departments()->sync($request->maintenance_department_id);

            Mail::send('email.systemadmin.welcome', ['user' => $user, 'password' => $password], function ($m) use ($user) {
                $m->from('hello@healthcare360.com', 'HealthCare360');
                $m->to($user->email, $user->name)->subject('Welcome to HealthCare360');
            });

            return redirect('admin/maintenance/users')->with('success', 'New maintenance user has been added!');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $healthsystem = HealthSystem::find(Auth::user()->healthsystem_id);
        $enabled_sites = [];
        $enabled_hcos = [];

        foreach ($user->buildings as $building) {
            $enabled_sites[] = $building->site->id;
            $enabled_hcos[] = $building->site->hco->id;
        }

        $sites = Site::whereIn('hco_id', $enabled_hcos)->pluck('name', 'id');
        $buildings = Building::whereIn('site_id', $enabled_sites)->pluck('name', 'id');
        $departments = BuildingDepartment::whereIn('building_id', $buildings->pluck('id'))->get();

        return view('maintenance.users.edit', ['user' => $user, 'healthsystem' => $healthsystem, 'enabled_hcos' => array_unique($enabled_hcos), 'enabled_sites' => array_unique($enabled_sites), 'sites' => $sites, 'buildings' => $buildings, 'departments' => $departments]);
    }

    public function save(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'maintenance_building_id' => 'required|array|exists:buildings,id'

        ]);

        $user = User::find($id);

        if ($user->update($request->all())) {
            $user->departments()->sync($request->maintenance_department_id);
            $user->buildings()->sync($request->maintenance_building_id);
            return redirect('admin/maintenance/users')->with('success', 'Maintenance user has been saved!');
        }
    }

    public function sites(Request $request)
    {
        $hcos = json_decode($request->hcos);
        $sites = [];

        foreach ($hcos as $hco) {
            foreach (HCO::find($hco)->sites as $site) {
                $sites[] = $site;
            }
        }

        return response()->json(['sites' => $sites]);
    }

    public function buildings(Request $request)
    {
        $sites = json_decode($request->sites);
        $buildings = [];

        foreach ($sites as $site) {
            foreach (Site::find($site)->buildings as $building) {
                $buildings[] = $building;
            }
        }

        return response()->json(['buildings' => $buildings]);
    }

    public function toggleUserState(Request $request)
    {
        $user = User::find($request->user_id);
        $user->update(['status' => $request->state]);
    }
}
