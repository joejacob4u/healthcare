<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regulatory\HealthSystem;
use App\Role;
use Auth;
use Hash;
use App\User;
use Mail;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except' => ['forgotView', 'sendTempPassword']]);
        $this->middleware('admin',['except' => ['forgotView', 'sendTempPassword']]);
    }

    public function index()
    {
      $users = HealthSystem::find(Auth::guard('web')->user()->healthsystem_id)->users;
      return view('users.index',['users' => $users]);
    }

    public function create()
    {
      $roles = Role::whereNotIn('name',['Master','System Admin','Business Partner'])->pluck('name','id');
      return view('users.add',['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'phone' => 'required|unique:users',
          'address' => 'required',
          'role_id' => 'required',
        ]);

        $password = str_random(8);

        $request->request->add(['password' => Hash::make($password)]);
        $request->request->add(['healthsystem_id' => Auth::guard('web')->user()->healthsystem_id]);

        if($user = User::create($request->all()))
        {
          $user->roles()->attach($request->role_id,['healthsystem_id' => Auth::guard('web')->user()->healthsystem_id]);

          Mail::send('email.systemadmin.welcome', ['user' => $user,'password' => $password], function ($m) use ($user) {
            $m->from('hello@healthcare360.com', 'HealthCare360');
            $m->to($user->email, $user->name)->subject('Welcome to HealthCare360');
          });

          return redirect('users')->with('success','New user has been added!');
        }
    }

    public function edit($id)
    {
      $user = User::find($id);
      $roles = Role::whereNotIn('name',['Master','System Admin','Business Partner'])->pluck('name','id');
      return view('users.edit',['user' => $user,'roles' => $roles]);
    }

    public function save(Request $request,$id)
    {
      $this->validate($request,[
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'role_id' => 'required',
      ]);

      $user = User::find($id);

      if($user->update($request->all()))
      {
        $user->roles()->syncWithoutDetaching([$request->role_id => ['healthsystem_id' => Auth::guard('web')->user()->healthsystem_id] ]);
        return redirect('users/')->with('success','User has been updated!');
      }

    }

    public function delete(Request $request)
    {
      if(User::destroy($request->id))
      {
          return 'true';
      }
    }

    public function forgotView()
    {
      return view('users.forgot');
    }

    public function sendTempPassword(Request $request)
    {
      $this->validate($request,[
        'email' => 'required|email',
      ]);

      $temp_password = str_random(8);

      User::where('email',$request->email)->update(['password' => Hash::make($temp_password),'forgot_password' => 1]);

      $email = $request->email;

      Mail::send('email.forgot', ['password' => $temp_password], function ($m) use ($email) {
        $m->from('hello@app.com', 'HealthCare Compliance 365');

        $m->to($email)->subject('Reset Password');
      });

      return redirect('/login');
    }

    public function temporaryCheck()
    {
      return Auth::guard('web')->user()->forgot_password;
    }

    public function temporaryChange(Request $request)
    {

        if (Hash::check($request->old_password, Auth::guard('web')->user()->password)) {
            Auth::guard('web')->user()->fill([
              'password' => Hash::make($request->new_password),
              'status' => 'active',
              'forgot_password' => 0,
            ])->save();

            return 'true';
        }
        else
        {
          return 'false';
        }
    }



}
