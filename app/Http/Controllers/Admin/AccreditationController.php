<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accreditation;


class AccreditationController extends Controller
{
    public function index()
    {
      $accreditations = Accreditation::get();
      return view('admin.accreditation.index',['accreditations' => $accreditations]);
    }

    public function create()
    {
      return view('admin.accreditation.add');
    }

    public function store(Request $request)
    {
      $this->validate($request,['name' => 'required|unique:accreditation,name']);
      $request->request->add(['slug' => $this->create_slug($request->name)]);


      if($accreditation = Accreditation::create($request->all()))
      {
        return redirect('admin/accreditation')->with('success','Accreditation created!');
      }
    }

    public function edit($id)
    {
        $accreditation = Accreditation::find($id);
        return view('admin.accreditation.edit',['accreditation' => $accreditation]);
    }

    public function delete($id)
    {
        if(Accreditation::destroy($id))
        {
          return redirect('admin/accreditation')->with('errors','Accreditation deleted!');
        }
    }

    private function create_slug($string)
    {
       $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
       return $slug;
    }

    public function info(Request $request)
    {
        $accreditation = Accreditation::find($request->id);
        return $accreditation->accreditationRequirements;
    }
}
