<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProspectUser;
use App\Trade;

class ProspectsController extends Controller
{
    public function index()
    {
      $trades = Trade::pluck('name','id');
      return view('prospects')->with('trades',$trades);
    }

    public function create(Request $request)
    {
      $this->validate($request, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:prospect_users',
          'password' => 'required|min:6|confirmed',
          'phone' => 'required'
      ]);


      if($prospect_user = ProspectUser::create($request->all()))
      {
        if(!empty($request->trades))
        {
          foreach($request->trades as $trade)
          {
            $aTrades[] = Trade::find($trade);
          }

          $prospect_user->trades()->saveMany($aTrades);

        }
        
        return back()->with('success','User added!');
      }
    }

}
