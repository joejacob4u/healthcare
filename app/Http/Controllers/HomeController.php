<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

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
        return view('home');
    }

    public function logout()
    {
        $guards = array_keys(config('auth.guards'));
        
        foreach ($guards as $guard) {
          if(Auth::guard($guard)->check())
          {
            Auth::guard($guard)->logout();
          }
          
        }
        Session::flush();
        return redirect('/login');
    }
}
