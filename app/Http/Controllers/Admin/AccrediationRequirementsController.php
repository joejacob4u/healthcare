<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Regulatory\Accrediation;
use App\Regulatory\AccrediationRequirement;


class AccrediationRequirementsController extends Controller
{
    public function index()
    {
        $accrediation_requirements = AccrediationRequirement::get();
        return view('admin.accrediation-requirement.index',['accrediation_requirements' => $accrediation_requirements]);
    }

    public function create()
    {
        $accrediations = Accrediation::pluck('name','id');
        return view('admin.accrediation-requirement.add',['accrediations' => $accrediations]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'name' => 'required|unique:accrediation_requirements,name',
          'accrediations' => 'required'
        ]);

        foreach($request->accrediations as $accrediation)
        {
          $aAccrediation[] = Accrediation::find($accrediation);
        }

        if($accrediation_requirement = AccrediationRequirement::create($request->all()))
        {
            if($accrediation_requirement->accrediations()->saveMany($aAccrediation))
            {
               return redirect('admin/accrediation-requirements')->with('success','Accrediation Requirement created!');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $accrediation_requirement = AccrediationRequirement::find($id);
        $accrediations = Accrediation::pluck('name','id');

        return view('admin.accrediation-requirement.edit',[
          'accrediation_requirement' => $accrediation_requirement,
          'accrediations' => $accrediations
        ]);
    }

    public function save(Request $request, $id)
    {
        $this->validate($request,[
          'name' => 'required',
          'accrediations' => 'required'
        ]);

        $accrediation_requirement = AccrediationRequirement::find($id);

        foreach($request->accrediations as $accrediation)
        {
          $aAccrediation[] = Accrediation::find($accrediation)->id;
        }

        if($accrediation_requirement->save($request->all()))
        {
            if($accrediation_requirement->accrediations()->sync($aAccrediation))
            {
               return redirect('admin/accrediation-requirements')->with('success','Accrediation Requirement updated!');
            }
        }
    }
}
