<?php

namespace App\Http\Controllers\Auth;

use App\ProspectUser;
use App\Trade;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $prospect_user = ProspectUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'corporation' => $data['corporation'],
            'partnership' => $data['partnership'],
            'sole_prop' => $data['sole_prop'],
            'company_owner' => $data['company_owner'],
            'contract_license_number' => $data['contract_license_number'],
            'status' => 'pending'
        ]);

        $trades = $data['trades'];

        if(!is_empty($trades) || isset($trades))
        {
          foreach($trades as $trade)
          {
            $aTrades[] = Trade::find($trade);
          }
          $prospect_user->trades()->saveMany($aTrades);
        }

        return redirect('/register')->with('success', 'You have been added');

    }
}
