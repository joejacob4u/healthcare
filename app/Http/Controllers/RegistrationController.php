<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contractor;
use App\Trade;
use App\User;
use App\Department;

class RegistrationController extends Controller
{
    public function index()
    {
      $trades = Trade::orderBy('name', 'ASC')->pluck('name','id');
      $departments = Department::orderBy('name', 'ASC')->pluck('name','id');
      return view('prospects')->with('trades',$trades)->with('departments',$departments);
    }

    public function create(Request $request)
    {

      if($request->is_contractor == 1)
      {
        
        $this->validate($request, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:contractors',
          'password' => 'required|min:6|confirmed',
          'phone' => 'required',
          'title' => 'required',
          'corporation' => 'required',
        ]);

        if($contractor = Contractor::create([
          'name' => $request->name,
          'email' => $request->email,
          'phone' => $request->phone,
          'address' => $request->address,
          'password' => bcrypt($request->password),
          'title' => $request->title,
          'corporation' => $request->corporation,
          'partnership' => $request->partnership,
          'company_owner' => $request->company_owner,
          'sole_prop' => $request->sole_prop,
          'contract_license_number' => $request->contract_license_number,
        ]))
        {
          if(!empty($request->trades))
          {
            foreach($request->trades as $trade)
            {
              $aTrades[] = Trade::find($trade);
            }
  
            $contractor->trades()->saveMany($aTrades);
  
          }
          
          return back()->with('success','User added!');
        }
      }
      else{

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
          'status' => 'pending',
        ]);
  
        if(!empty($request->departments))
        {
          foreach($request->departments as $department)
          {
            $aDepartments[] = Department::find($department);
          }
  
          $user->departments()->saveMany($aDepartments);
        }
  

      }
  

      }






}
