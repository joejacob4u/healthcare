<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\EOP;
use App\Regulatory\SubCOP;



class EOPController extends Controller
{
    public function index($standard_label)
    {
        $standard_label = StandardLabel::find($standard_label);
        return view('admin.eop.index',['standard_label' => $standard_label]);
    }

    public function create($standard_label)
    {
        $standard_label = StandardLabel::find($standard_label);
        $cops = SubCOP::pluck('label','id');
        return view('admin.eop.add',['standard_label' => $standard_label,'cops' => $cops]);
    }

    public function store(Request $request,$standard_label)
    {
        $this->validate($request,[
          'name' => 'required|unique:eop,name',
          'text' => 'required',
          'documentation' => 'required',
          'frequency' => 'required',
          'risk' => 'required',
          'risk_assessment' => 'required',
          'cops' => 'required'
        ]);

        $standardLabel = StandardLabel::find($standard_label);

        foreach($request->cops as $cop)
        {
          $aCops[] = SubCOP::find($cop);
        }

        if($eop = $standardLabel->eops()->create($request->all()))
        {
           if($eop->subCOPs()->saveMany($aCops))
           {
             return redirect('admin/standard-label/'.$standard_label.'/eop')->with('success','EOP created successfully');
           }
        }

    }

    public function edit($standard_label,$eop)
    {
        $standard_label = StandardLabel::find($standard_label);
        $eop = EOP::find($eop);
        return view('admin.eop.edit',['standard_label' => $standard_label, 'eop' => $eop]);
    }

    public function save(Request $request,$standard_label,$eop)
    {
        $this->validate($request,[
          'name' => 'required',
          'text' => 'required',
          'documentation' => 'required',
          'frequency' => 'required',
          'risk' => 'required',
          'risk_assessment' => 'required'
        ]);

        $standardLabel = StandardLabel::find($standard_label);
        $eop = EOP::find($eop);
        $eop->update($request->all());

        if($standardLabel->eops()->save($eop))
        {
           return redirect('admin/standard-label/'.$standard_label.'/eop')->with('success','EOP saved successfully');
        }

    }

    public function delete($standard_label,$eop)
    {
      if(EOP::destroy($eop))
      {
        return redirect('admin/standard-label/'.$standard_label.'/eop')->with('error','EOP deleted successfully');
      }
    }

}
