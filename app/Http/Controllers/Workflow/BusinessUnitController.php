<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Workflow\BusinessUnit;

class BusinessUnitController extends Controller
{
    public function index()
    {
        $business_units = BusinessUnit::get();
        return view('workflow.business_unit.index',['business_units' => $business_units]);
    }

    public function create()
    {
        return view('workflow.business_unit.add');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'business_unit_number' => 'required',
            'description' => 'required'
        ]);

        if(BusinessUnit::create($request->all()))
        {
            return redirect('workflows/business-units')->with('success','New business unit added!');
        }
    }

    public function edit($business_unit)
    {
        $business_unit = BusinessUnit::find($business_unit);
        return view('workflow.business_unit.edit',['business_unit' => $business_unit]);
    }

    public function save(Request $request,$business_unit)
    {
        $this->validate($request,[
            'business_unit_number' => 'required',
            'description' => 'required'
        ]);

        $business_unit = BusinessUnit::find($business_unit);

        if($business_unit->update($request->all()))
        {
            return redirect('workflows/business-units')->with('success','Business unit added!');
        }
    }

    public function delete(Request $request)
    {
        if(BusinessUnit::destroy($request->business_unit_id))
        {
            return back()->with('success','Business unit deleted!');
        }
    }

}
