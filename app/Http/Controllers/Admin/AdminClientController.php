<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Admin\Department;
use App\Admin\Client;
use App\Admin\AccrType;
use App\Http\Controllers\Controller;


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

      return view('admin.client.add',[
          'page_description' => 'Add your clients here:',
          'page_title' => 'Add Clients'
      ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
        'healthcare_system' => 'required',
        'facility_name' => 'required',
        'address' => 'required',
        'hco_id' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required|unique:clients',
        'admin_phone' => 'required|unique:clients',
        'state' => 'required'
      ]);

      if(Client::create($request->all()))
      {
        return redirect('admin/admin/clients')->with('success','The client has been added!');

      }
    }

    public function edit($client_id)
    {
      $client = Client::find($client_id);
      return view('admin.client.edit',['client' => $client]);
    }

    public function save(Request $request,$client_id)
    {
        $this->validate($request, [
        'healthcare_system' => 'required',
        'facility_name' => 'required',
        'address' => 'required',
        'hco_id' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required|email',
        'admin_phone' => 'required',
        'state' => 'required'
      ]);

      $client = Client::find($client_id);

      if($client->update($request->all()))
      {
        return redirect('admin/admin/clients')->with('success','The client has been updated!');
      }
    }


}
