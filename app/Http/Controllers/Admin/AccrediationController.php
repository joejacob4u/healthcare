<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accrediation;
use App\Regulatory\SubCOP;


class AccrediationController extends Controller
{
    public function index()
    {
      $accrediations = Accrediation::get();
      return view('admin.accrediation.index',['accrediations' => $accrediations]);
    }

    public function create()
    {
      $cops = SubCOP::orderBy('label','asc')->pluck('label','id');
      return view('admin.accrediation.add',['cops' => $cops]);
    }

    public function store(Request $request)
    {
      $this->validate($request,['name' => 'required|unique:accrediation,name','cop' => 'required']);
      $request->request->add(['slug' => $this->create_slug($request->name)]);

      foreach($request->cop as $cop)
      {
         $cops [] = SubCOP::find($cop);
      }

      if($accrediation = Accrediation::create($request->all()))
      {
        if($accrediation->subCOPs()->saveMany($cops))
        {
          return redirect('admin/accrediation')->with('success','Accrediation created!');
        }
      }
    }

    public function edit($id)
    {
        $accrediation = Accrediation::find($id);
        $cops = SubCOP::orderBy('label','asc')->pluck('label','id');
        return view('admin.accrediation.edit',['accrediation' => $accrediation,'cops' => $cops]);
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
