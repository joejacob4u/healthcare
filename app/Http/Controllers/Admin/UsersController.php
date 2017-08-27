<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Regulatory\HealthSystem;
use Hash;
use Mail;
use App\ProspectUser;

class UsersController extends Controller
{
    public function index()
    {
      $users = User::whereHas('roles', function($q) { $q->where('role_id',2); })->get();
      return view('admin.healthsystem.users.index',['users' => $users]);
    }

    public function create()
    {
      $healthcare_systems = HealthSystem::pluck('healthcare_system','id');
      $prospects = User::whereHas('roles', function($q) { $q->where('role_id',12); })->pluck('email','id');
      return view('admin.healthsystem.users.add',['healthcare_systems' => $healthcare_systems,'prospects' => $prospects]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'prospect_id' => 'required',
          'healthsystem_id' => 'required'
        ]);

        $user = User::find($request->prospect_id);

        $user->roles()->sync([$request->role_id => ['healthsystem_id' => $request->healthsystem_id]]);
        $user->healthSystems()->attach($request->healthsystem_id);

        Mail::send('email.systemadmin.welcome', [], function ($m) use ($user) {
          $m->from('hello@healthcare360.com', 'HealthCare Compliance 365');
          $m->to($user->email, $user->name)->subject('Welcome to HealthCare Compliance 365');
        });

        return redirect('admin/healthsystem/users/')->with('success','New system admin has been added!');
    }

    public function edit($id)
    {
      $user = User::find($id);
      $healthcare_systems = HealthSystem::pluck('healthcare_system','id');
      return view('admin.healthsystem.users.edit',['healthcare_systems' => $healthcare_systems,'user' => $user]);
    }

    public function save(Request $request,$id)
      {
        $this->validate($request,[
          'prospect_id' => 'required',
          'healthsystem_id' => 'required'
        ]);

        $user = User::find($id);

        $user->roles()->syncWithoutDetaching([$request->role_id => ['healthsystem_id' => $request->healthsystem_id]]);
        $user->healthSystems()->syncWithoutDetaching([$request->healthsystem_id]);

        return redirect('admin/healthsystem/users/')->with('success','System admin has been updated!');
    }


    public function delete(Request $request)
    {
      if(User::destroy($request->id))
      {
          return redirect('admin/healthsystem/users/')->with('success','system admin has been deleted!');
      }
    }

}
