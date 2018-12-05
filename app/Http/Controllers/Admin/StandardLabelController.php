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
            return redirect('admin/admin/standard-label');
        }

        $accreditations = Accreditation::pluck('name', 'id');
        $accreditation_requirements = AccreditationRequirement::pluck('name', 'id');

        $accreditation = Accreditation::find($request->accreditation);
        $standard_labels = $accreditation->standardLabels;
        $accreditation_requirement = AccreditationRequirement::find($request->accreditation_requirement);

        foreach ($standard_labels as $key => $standard_label) {
            if ($standard_label->accreditation_requirement_id == $request->accreditation_requirement) {
                $filtered_standard_labels[] = $standard_labels->pull($key);
            }
        }

        if (!isset($filtered_standard_labels)) {
            return redirect('admin/admin/standard-label')->with('warning', 'Filter returned no matches.');
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
          'accreditation_id' => 'required',
          'accreditation_requirement_id' => 'required'
        ]);

        foreach ($request->accreditation_id as $accreditation) {
            $aAccreditations[] = Accreditation::find($accreditation);
        }

        if ($standard_label = StandardLabel::create($request->all())) {
            if ($standard_label->accreditations()->saveMany($aAccreditations)) {
                return redirect('admin/admin/standard-label')->with('success', 'Standard Label created!');
            }
        }
    }

    public function edit($id)
    {
        $standard_label = StandardLabel::find($id);
        
        $available_accreditations = $standard_label->accreditations->pluck('id')->toArray();

        $accreditations = Accreditation::pluck('name', 'id');

        $accreditation_requirements = AccreditationRequirement::whereHas('accreditations', function ($q) use ($available_accreditations) {
            $q->whereIn('id', $available_accreditations);
        })->pluck('name', 'id');


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
          'accreditation_id' => 'required',
          'accreditation_requirement_id' => 'required'
        ]);

        $standard_label = StandardLabel::find($id);

        foreach ($request->accreditation_id as $accreditation) {
            $aAccreditations[] = Accreditation::find($accreditation)->id;
        }

        if ($standard_label->update($request->all())) {
            if ($standard_label->accreditations()->sync($aAccreditations)) {
                return redirect('admin/admin/standard-label')->with('success', 'Standard Label updated!');
            }
        }
    }

    public function delete($id)
    {
        if (StandardLabel::destroy($id)) {
            return redirect('admin/admin/standard-label')->with('success', 'Standard Label deleted!');
        }
    }

    public function fetchAccreditationRequirements(Request $request)
    {
        $accreditation= Accreditation::find($request->accreditation);
        return $accreditation->accreditationRequirements;
    }

    public function fetchMultipleAccreditationRequirements(Request $request)
    {
        $accreditations = json_decode($request->accreditations);

        $accreditation_requirements = [];

        foreach ($accreditations as $accreditation) {
            foreach (Accreditation::find($accreditation)->accreditationRequirements as $accreditation_requirement) {
                $accreditation_requirements[] = $accreditation_requirement;
            }
        }

        return response()->json(['accreditation_requirements' => $accreditation_requirements]);
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
