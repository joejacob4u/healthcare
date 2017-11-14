<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ContractorAuthController extends Controller
{
    public function login()
    {
        return view('auth.contractor');
    }

    public function authenticate(Request $request)
    {
        if (Auth::guard('contractor')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        }
    }
}
