<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\AccrediationRequirement;

class StandardLabelController extends Controller
{
    public function index()
    {
      $standard_labels = StandardLabel::get();
      return view('admin.standard-label.index',['standard_labels' => $standard_labels]);
    }

    public function create()
    {
      $accrediation_requirements = AccrediationRequirement::pluck('name','id');
      return view('admin.standard-label.add',['accrediation_requirements' => $accrediation_requirements]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'label' => 'required|unique:standard_label,label',
          'text' => 'required',
          'description' => 'required',
          'accrediation_requirements' => 'required'
        ]);

        foreach($request->accrediation_requirements as $accrediation_requirement)
        {
          $aAccrediationRequirements[] = AccrediationRequirement::find($accrediation_requirement);
        }

        if($standard_label = StandardLabel::create($request->all()))
        {
            if($standard_label->accrediationRequirements()->saveMany($aAccrediationRequirements))
            {
               return redirect('admin/standard-label')->with('success','Standard Label created!');
            }
        }
    }

    public function edit($id)
    {
      $accrediation_requirements = AccrediationRequirement::pluck('name','id');
      $standard_label = StandardLabel::find($id);

      return view('admin.standard-label.edit',[
        'accrediation_requirements' => $accrediation_requirements,
        'standard_label' => $standard_label
      ]);
    }


    public function save(Request $request)
    {

    }
}
