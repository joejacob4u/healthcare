<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Client;

class AdminClientController extends Controller
{
    public function index()
    {
        $clients = Client::get();

        return view('admin.client.index',[
            'clients' => $clients,
            'page_description' => 'Manage your clients here:',
            'page_title' => 'Clients'
        ]);
    }

    public function addView()
    {

      $departments = Department::pluck('name','id');

      return view('admin.client.add',[
          'departments' => $departments,
          'page_description' => 'Add your clients here:',
          'page_title' => 'Add Clients'
      ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
        'name' => 'required|max:255',
        'email' => 'required|unique:clients',
        'phone' => 'required',
        'address' => 'required',
        'departments' => 'required'
      ]);


      foreach($request->departments as $departments)
      {
          $aDepartments[] = AccrType::find($departments);
      }

      if($client = Client::create($request->all()))
      {
          if($client->accrTypes()->saveMany($aDepartments))
          {
             return redirect('admin/clients')->with('success','The client has been added!');
          }
      }
    }


}
