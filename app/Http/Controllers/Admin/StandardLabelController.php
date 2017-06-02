<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\AccreditationRequirement;
use App\Regulatory\Accreditation;

class StandardLabelController extends Controller
{
    public function index()
    {
      $standard_labels = StandardLabel::get();
      $accreditations = Accreditation::pluck('name','id');
      $accreditation_requirements = AccreditationRequirement::pluck('name','id');
      return view('admin.standard-label.index',['standard_labels' => $standard_labels,'accreditation_requirements' => $accreditation_requirements,'accreditation_requirement' => '','accreditations' => $accreditations,'accreditation' => '']);
    }

    public function filter(Request $request)
    {

      if(!is_numeric ($request->accreditation_requirement))
      {
        return redirect('admin/standard-label');
      }

      $accreditations = Accreditation::pluck('name','id');
      $accreditation_requirements = AccreditationRequirement::pluck('name','id');
      $standard_labels = StandardLabel::where('accreditation_id',$request->accreditation)->get();
      $filtered_standard_labels = $standard_labels->accreditationRequirements->contains($request->accreditation_requirement);
      return view('admin.standard-label.index',['standard_labels' => $filtered_standard_labels,'accreditation_requirements' => $accreditation_requirements, 'accreditation_requirement' => $request->accreditation_requirement,'accreditations' => $accreditations,'accreditation' => $request->accreditation]);
    }

    public function create()
    {
      $accreditation_requirements = AccreditationRequirement::pluck('name','id');
      $accreditations = Accreditation::pluck('name','id');
      return view('admin.standard-label.add',['accreditation_requirements' => $accreditation_requirements,'accreditations' => $accreditations]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'label' => 'required|unique:standard_label,label',
          'text' => 'required',
          'description' => 'required',
          'accreditation_requirements' => 'required',
          'accreditation_id' => 'required'
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
          'accreditation_requirements' => 'required',
          'accreditation_id' => 'required'

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

    public function fetchAccreditationRequirements(request $request)
    {
        $accreditation= Accreditation::find($request->accreditation);
        return $accreditation->accreditationRequirements;
    }
}
