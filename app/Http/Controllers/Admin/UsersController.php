<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Regulatory\HealthSystem;
use Hash;
use Mail;

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
      return view('admin.healthsystem.users.add',['healthcare_systems' => $healthcare_systems]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'phone' => 'required|unique:users',
          'address' => 'required',
          'role_id' => 'required',
          'healthsystem_id' => 'required'
        ]);

        $request->request->add(['password' => Hash::make(str_random(8))]);

        if($user = User::create($request->all()))
        {
          $user->roles()->attach($request->role_id);

          Mail::send('email.systemadmin.welcome', ['user' => $user,'password' => $request->password], function ($m) use ($user) {
            $m->from('hello@healthcare360.com', 'HealthCare360');
            $m->to($user->email, $user->name)->subject('Welcome to HealthCare360');
          });

          return redirect('admin/healthsystem/users/')->with('success','New system admin has been added!');
        }
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
          'name' => 'required',
          'email' => 'required|email',
          'phone' => 'required',
          'address' => 'required',
          'role_id' => 'required',
          'healthsystem_id' => 'required'
        ]);

        $user = User::find($id);

        if($user->update($request->all()))
        {
          return redirect('admin/healthsystem/users/')->with('success','System admin has been updated!');
        }
    }


    public function delete(Request $request)
    {
      if(User::destroy($request->id))
      {
          return redirect('admin/healthsystem/users/')->with('success','system admin has been deleted!');
      }
    }

}
