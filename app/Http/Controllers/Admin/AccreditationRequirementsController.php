<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Regulatory\Accreditation;
use App\Regulatory\AccreditationRequirement;


class AccreditationRequirementsController extends Controller
{
    public function index()
    {
        $accreditation_requirements = AccreditationRequirement::get();
        return view('admin.accreditation-requirement.index',['accreditation_requirements' => $accreditation_requirements]);
    }

    public function create()
    {
        $accreditations = Accreditation::pluck('name','id');
        return view('admin.accreditation-requirement.add',['accreditations' => $accreditations]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'name' => 'required|unique:accreditation_requirements,name',
          'accreditations' => 'required'
        ]);

        foreach($request->accreditations as $accreditation)
        {
          $aAccreditation[] = Accreditation::find($accreditation);
        }

        if($accreditation_requirement = AccreditationRequirement::create($request->all()))
        {
            if($accreditation_requirement->accreditations()->saveMany($aAccreditation))
            {
               return redirect('admin/accreditation-requirements')->with('success','Accreditation Requirement created!');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $accreditation_requirement = AccreditationRequirement::find($id);
        $accreditations = Accreditation::pluck('name','id');

        return view('admin.accreditation-requirement.edit',[
          'accreditation_requirement' => $accreditation_requirement,
          'accreditations' => $accreditations
        ]);
    }

    public function save(Request $request, $id)
    {
        $this->validate($request,[
          'name' => 'required',
          'accreditations' => 'required'
        ]);

        $accreditation_requirement = AccreditationRequirement::find($id);

        foreach($request->accreditations as $accreditation)
        {
          $aAccreditation[] = Accreditation::find($accreditation)->id;
        }

        if($accreditation_requirement->update($request->all()))
        {
            if($accreditation_requirement->accreditations()->sync($aAccreditation))
            {
               return redirect('admin/accreditation-requirements')->with('success','Accreditation Requirement updated!');
            }
        }
    }

    public function delete($id)
    {
        if(AccreditationRequirement::destroy($id))
        {
            return redirect('admin/accreditation-requirements')->with('success','Accreditation Requirement deleted!');
        }
    }

    public function info(Request $request)
    {
        $accreditationRequirement = AccreditationRequirement::find($request->id);
        return $accreditationRequirement->standardLabels;
    }
}
