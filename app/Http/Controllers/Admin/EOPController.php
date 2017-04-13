<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\EOP;


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
        return view('admin.eop.add',['standard_label' => $standard_label]);
    }

    public function store(Request $request,$standard_label)
    {
        $this->validate($request,[
          'name' => 'required|unique:eop,name',
          'text' => 'required',
          'documentation' => 'required',
          'frequency' => 'required',
          'risk' => 'required',
          'risk_assessment' => 'required'
        ]);

        $standard_label = StandardLabel::find($standard_label);

        if($standard_label->eops()->create($request->all()))
        {
           return redirect('admin/standard_label/'.$standard_label.'/eop')->with('success','EOP created successfully');
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
          'name' => 'required|unique:eop,name',
          'text' => 'required',
          'documentation' => 'required',
          'frequency' => 'required',
          'risk' => 'required',
          'risk_assessment' => 'required'
        ]);

        $standard_label = StandardLabel::find($standard_label);

        if($standard_label->eops()->associate(EOP::find($eop))->save($request->all()))
        {
           return redirect('admin/standard_label/'.$standard_label.'/eop')->with('success','EOP created successfully');
        }

    }

}
