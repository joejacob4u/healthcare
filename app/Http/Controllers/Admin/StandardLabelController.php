<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\AccreditationRequirement;

class StandardLabelController extends Controller
{
    public function index()
    {
      $standard_labels = StandardLabel::get();
      $accreditation_requirements = AccreditationRequirement::pluck('name','id');
      return view('admin.standard-label.index',['standard_labels' => $standard_labels,'accreditation_requirements' => $accreditation_requirements,'accreditation_requirement' => '']);
    }

    public function filter(Request $request)
    {
      
      if(!is_numeric ($request->accreditation_requirement))
      {
        return redirect('admin/standard-label');
      }

      $accrediation_requirement = AccreditationRequirement::find($request->accreditation_requirement);
      $standard_labels = $accrediation_requirement->standardLabels;
      $accreditation_requirements = AccreditationRequirement::pluck('name','id');
      return view('admin.standard-label.index',['standard_labels' => $standard_labels,'accreditation_requirements' => $accreditation_requirements, 'accreditation_requirement' => $request->accreditation_requirement]);
    }

    public function create()
    {
      $accreditation_requirements = AccreditationRequirement::pluck('name','id');
      return view('admin.standard-label.add',['accreditation_requirements' => $accreditation_requirements]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'label' => 'required|unique:standard_label,label',
          'text' => 'required',
          'description' => 'required',
          'accreditation_requirements' => 'required'
        ]);

        foreach($request->accreditation_requirements as $accreditation_requirement)
        {
          $aAccreditationRequirements[] = AccreditationRequirement::find($accreditation_requirement);
        }

        if($standard_label = StandardLabel::create($request->all()))
        {
            if($standard_label->accreditationRequirements()->saveMany($aAccreditationRequirements))
            {
               return redirect('admin/standard-label')->with('success','Standard Label created!');
            }
        }
    }

    public function edit($id)
    {
      $accreditation_requirements = AccreditationRequirement::pluck('name','id');
      $standard_label = StandardLabel::find($id);

      return view('admin.standard-label.edit',[
        'accreditation_requirements' => $accreditation_requirements,
        'standard_label' => $standard_label
      ]);
    }


    public function save(Request $request,$id)
    {
        $this->validate($request,[
          'label' => 'required',
          'text' => 'required',
          'description' => 'required',
          'accreditation_requirements' => 'required'
        ]);

        $standard_label = StandardLabel::find($id);

        foreach($request->accreditation_requirements as $accreditation_requirement)
        {
          $aAccreditationRequirements[] = AccreditationRequirement::find($accreditation_requirement)->id;
        }

        if($standard_label->save($request->all()))
        {
            if($standard_label->accreditationRequirements()->sync($aAccreditationRequirements))
            {
               return redirect('admin/standard-label')->with('success','Standard Label updated!');
            }
        }

    }

    public function delete($id)
    {
        if(StandardLabel::destroy($id))
        {
            return redirect('admin/standard-label')->with('success','Standard Label deleted!');
        }
    }
}
