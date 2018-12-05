<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\COP;

class COPController extends Controller
{
  public function index()
  {
    $cops = COP::orderBy('label','asc')->get();
    return view('admin.cop.index',['cops' => $cops]);
  }

  public function addView()
  {
    return view('admin.cop.add');
  }

  public function create(Request $request)
  {
    $this->validate($request,[
      'label' => 'required|unique:cop',
      'title' => 'required',
    ]);

    if(COP::create($request->all()))
    {
      return redirect('admin/admin/cop')->with('success','COP has been created!');
    }
  }

  public function editView($id)
  {
      $cop = COP::find($id);
      return view('admin.cop.edit',['cop' => $cop]);
  }

  public function save(Request $request,$id)
  {
    $this->validate($request,[
      'label' => 'required',
      'title' => 'required',
    ]);

    $cop = COP::find($id);

    if($cop->update($request->all()))
    {
      return redirect('admin/admin/cop')->with('success','COP has been updated!');
    }
  }

  public function delete(Request $request)
  {
     if(COP::destroy($request->id))
     {
       return 'true';
     }
  }
}
