<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\RequirementFrequency;

class RequirementFrequencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $requirement_frequencies = RequirementFrequency::get();
        return view('equipment.requirement-frequency', ['requirement_frequencies' => $requirement_frequencies]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:equipment_frequency_requirements,name',
            'score' => 'required|numeric'
        ]);

        if (RequirementFrequency::create($request->all())) {
            return back()->with('success', 'Requirement Frequency created!');
        }
    }

    public function delete(Request $request)
    {
        RequirementFrequency::destroy($request->id);
        return 'true';
    }
}
