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
        $standard_labels = StandardLabel::orderBy('label', 'asc')->get();
        $accreditations = Accreditation::pluck('name', 'id');
        $accreditation_requirements =  AccreditationRequirement::pluck('name', 'id');
        return view('admin.standard-label.index', ['standard_labels' => $standard_labels,'accreditation_requirements' => $accreditation_requirements,'accreditation_requirement' => '','accreditations' => $accreditations,'accreditation' => '']);
    }

    public function filter(Request $request)
    {
        if (!is_numeric($request->accreditation_requirement)) {
            return redirect('admin/standard-label');
        }

        $accreditations = Accreditation::pluck('name', 'id');
        $accreditation_requirements = AccreditationRequirement::pluck('name', 'id');

        $accreditation = Accreditation::find($request->accreditation);
        $standard_labels = $accreditation->standardLabels;
        $accreditation_requirement = AccreditationRequirement::find($request->accreditation_requirement);

        foreach ($standard_labels as $key => $standard_label) {
            if ($standard_label->accreditationRequirements->contains($request->accreditation_requirement)) {
                $filtered_standard_labels[] = $standard_labels->pull($key);
            }
        }

        if (!isset($filtered_standard_labels)) {
            return redirect('admin/standard-label')->with('warning', 'Filter returned no matches.');
        }

        return view('admin.standard-label.index', ['standard_labels' => $filtered_standard_labels,'accreditation_requirements' => $accreditation_requirements, 'accreditation_requirement' => $request->accreditation_requirement,'accreditations' => $accreditations,'accreditation' => $request->accreditation]);
    }

    public function create()
    {
        $accreditation_requirements = AccreditationRequirement::pluck('name', 'id');
        $accreditations = Accreditation::pluck('name', 'id');
        return view('admin.standard-label.add', ['accreditation_requirements' => $accreditation_requirements,'accreditations' => $accreditations]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'label' => 'required',
          'text' => 'required',
          'accreditation_requirements' => 'required',
          'accreditation_id' => 'required'
        ]);

        foreach ($request->accreditation_requirements as $accreditation_requirement) {
            $aAccreditationRequirements[] = AccreditationRequirement::find($accreditation_requirement);
        }

        if ($standard_label = StandardLabel::create($request->all())) {
            if ($standard_label->accreditationRequirements()->saveMany($aAccreditationRequirements)) {
                return redirect('admin/standard-label')->with('success', 'Standard Label created!');
            }
        }
    }

    public function edit($id)
    {
        $accreditation_requirements = AccreditationRequirement::pluck('name', 'id');
        $accreditations = Accreditation::pluck('name', 'id');
        $standard_label = StandardLabel::find($id);

        return view('admin.standard-label.edit', [
        'accreditation_requirements' => $accreditation_requirements,
        'standard_label' => $standard_label,
        'accreditations' => $accreditations
      ]);
    }


    public function save(Request $request, $id)
    {
        $this->validate($request, [
          'label' => 'required',
          'text' => 'required',
          'accreditation_requirements' => 'required',
          'accreditation_id' => 'required'

        ]);

        $standard_label = StandardLabel::find($id);

        foreach ($request->accreditation_requirements as $accreditation_requirement) {
            $aAccreditationRequirements[] = AccreditationRequirement::find($accreditation_requirement)->id;
        }

        if ($standard_label->update($request->all())) {
            if ($standard_label->accreditationRequirements()->sync($aAccreditationRequirements)) {
                return redirect('admin/standard-label')->with('success', 'Standard Label updated!');
            }
        }
    }

    public function delete($id)
    {
        if (StandardLabel::destroy($id)) {
            return redirect('admin/standard-label')->with('success', 'Standard Label deleted!');
        }
    }

    public function fetchAccreditationRequirements(request $request)
    {
        $accreditation= Accreditation::find($request->accreditation);
        return $accreditation->accreditationRequirements;
    }

    public function fetchEOPS(Request $request)
    {
        $eops = [];
        $standard_labels = json_decode($request->standard_labels);

        foreach ($standard_labels as $standard_label) {
            $standard_label = StandardLabel::find($standard_label);
            foreach ($standard_label->eops as $eop) {
                $eops[] = $eop;
            }
        }

        return response()->json(['eops' => $eops]);
    }
}
