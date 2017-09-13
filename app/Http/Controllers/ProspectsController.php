<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProspectUser;
use App\Trade;
use App\User;
use App\Department;

class ProspectsController extends Controller
{
    public function index()
    {
      $trades = Trade::pluck('name','id');
      $departments = Department::pluck('name','id');
      return view('prospects')->with('trades',$trades)->with('departments',$departments);
    }

    public function create(Request $request)
    {
      $this->validate($request, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
          'phone' => 'required'
      ]);

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'password' => bcrypt($request->password),
        'status' => 'active',
        'is_contractor' => (!empty($request->trades)) ? 1 : 0
      ]);

      if(!empty($request->departments))
      {
        foreach($request->departments as $department)
        {
          $aDepartments[] = Department::find($department);
        }

        $user->departments()->saveMany($aDepartments);
      }


      $user->roles()->attach(12);


      if($prospect_user = ProspectUser::create([
        'user_id' => $user->id,
        'title' => $request->title,
        'corporation' => $request->corporation,
        'partnership' => $request->partnership,
        'company_owner' => $request->company_owner,
        'sole_prop' => $request->sole_prop,
        'contract_license_number' => $request->contract_license_number,
        'status' => 'available'
      ]))
      {
        if(!empty($request->trades))
        {
          foreach($request->trades as $trade)
          {
            $aTrades[] = Trade::find($trade);
          }

          $user->trades()->saveMany($aTrades);
          $user->is_contractor = 1;

        }
        
        return back()->with('success','User added!');
      }
    }

}
