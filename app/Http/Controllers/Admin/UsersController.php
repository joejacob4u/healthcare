<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Regulatory\HealthSystem;
use Hash;
use Mail;
use App\Contractor;
use App\Trade;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $users = User::where('role_id', 2)->get();
        return view('admin.healthsystem.users.index', ['users' => $users]);
    }

    public function create()
    {
        $healthcare_systems = HealthSystem::pluck('healthcare_system', 'id');
        $trades = Trade::pluck('id');
        $prospects = User::where('role_id', 0)->pluck('email', 'id');
        return view('admin.healthsystem.users.add', ['healthcare_systems' => $healthcare_systems,'prospects' => $prospects]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'prospect_id' => 'required',
          'healthsystem_id' => 'required'
        ]);

        $user = User::find($request->prospect_id);

        if ($user->update(['role_id' => 2,'healthsystem_id' => $request->healthsystem_id])) {
            Mail::send('email.systemadmin.welcome', [], function ($m) use ($user) {
                $m->from('hello@healthcare360.com', 'HealthCare Compliance 365');
                $m->to($user->email, $user->name)->subject('Welcome to HealthCare Compliance 365');
            });
    
            return redirect('admin/healthsystem/users/')->with('success', 'New system admin has been added!');
        }
    }

    public function delete(Request $request)
    {
        if (User::destroy($request->id)) {
            return redirect('admin/healthsystem/users/')->with('success', 'system admin has been deleted!');
        }
    }
}
