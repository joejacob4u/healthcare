<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accrediation;


class AccrediationController extends Controller
{
    public function index()
    {
      $accrediations = Accrediation::get();
      return view('admin.accrediation.index',['accrediations' => $accrediations]);
    }

    public function create()
    {
      return view('admin.accrediation.add');
    }

    public function store(Request $request)
    {
      $this->validate($request,['name' => 'required|unique:accrediation,name']);
      $request->request->add(['slug' => $this->create_slug($request->name)]);


      if($accrediation = Accrediation::create($request->all()))
      {
        return redirect('admin/accrediation')->with('success','Accrediation created!');
      }
    }

    public function edit($id)
    {
        $accrediation = Accrediation::find($id);
        return view('admin.accrediation.edit',['accrediation' => $accrediation]);
    }

    public function delete($id)
    {
        if(Accrediation::destroy($id))
        {
          return redirect('admin/accrediation')->with('errors','Accrediation deleted!');
        }
    }

    private function create_slug($string)
    {
       $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
       return $slug;
    }
}
