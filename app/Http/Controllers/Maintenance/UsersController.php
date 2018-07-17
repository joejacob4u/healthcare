<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Regulatory\HealthSystem;
use Mail;

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
            'building_id' => 'required|array|exists:buildings,id'

        ]);
        
        if ($user = User::create($request->all())) {
            $user->buildings()->sync($request->building_id);
            
            Mail::send('email.systemadmin.welcome', [], function ($m) use ($user) {
                $m->from('hello@healthcare360.com', 'HealthCare Compliance 365');
                $m->to($user->email, $user->name)->subject('Welcome to HealthCare Compliance 365');
            });
    
            return back()->with('success', 'New maintenance user has been added!');
        }
    }
}
