<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\COP;
use App\Regulatory\SubCOP;
use App\Regulatory\AccrediationRequirement;


class SubCOPController extends Controller
{
    public function index($id)
    {
        $cop = COP::find($id);
        return view('admin.cop.subcop.index',['cop' => $cop]);
    }

    public function addView($id)
    {
      $cop = COP::find($id);
      return view('admin.cop.subcop.add',['cop' => $cop]);
    }

    public function create(Request $request,$id)
    {
      $this->validate($request,[
        'label' => 'required|unique:sub_cop',
        'title' => 'required',
        'accr_types' => 'required',
        'compliant' => 'required'
      ]);

      $cop = COP::find($id);


      if($sub_cop = $cop->subCOPs()->create($request->all()))
      {
        return redirect('admin/cop/'.$cop->id.'/subcop/')->with('success','SubCOP has been created!');
      }
    }

    public function editView($cop_id,$sub_cop_id)
    {
        $sub_cop = SubCOP::find($sub_cop_id);
        $cop = COP::find($cop_id);
        return view('admin.cop.subcop.edit',['sub_cop' => $sub_cop,'cop' => $cop ]);
    }

    public function save($cop_id,$sub_cop_id)
    {
      $this->validate($request,[
        'label' => 'required',
        'title' => 'required',
        'compliant' => 'required'
      ]);

      $sub_cop = SubCOP::find($sub_cop_id);

      if($sub_cop->save($request->all()))
      {
        return redirect('admin/cop/'.$cop_id.'/subcop')->with('success','SubCOP has been updated!');
      }
    }

    public function delete(Request $request)
    {
       if(SubCOP::destroy($request->id))
       {
         return 'true';
       }
    }


}
