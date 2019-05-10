<?php

namespace App\Http\Controllers\Frontend\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Assessment\Section;
use App\Assessment\Assessment;
use App\Regulatory\BuildingDepartment;
use App\User;
use App\Equipment\Equipment;
use App\Regulatory\Room;

class AssessmentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('user');
    }

    public function index()
    {
        $assessments = Assessment::where('building_id', session('building_id'))->orderByDesc('created_at')->paginate(15);
        return view('assessment.index', ['assessments' => $assessments]);
    }

    public function create()
    {
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id');
        $assessment_sections = Section::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('assessment.add', ['departments' => $departments, 'assessment_sections' => $assessment_sections, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'building_department_id' => 'required',
            'assessment_section_id' => 'required',
            'assessment_checklist_type_id' => 'required'
        ]);

        if (Assessment::create($request->all())) {
            return redirect('/assessments')->with('success', 'New assessment created.');
        }
    }

    public function evaluate(Assessment $assessment)
    {
        $equipments = Equipment::where('building_id', session('building_id'))->get();

        $inventories = [];

        foreach ($equipments as $equipment) {
            foreach ($equipment->inventories as $inventory) {
                $inventories[$inventory->id] = $inventory;
            }
        }

        $rooms = Room::where('building_department_id', $assessment->department->id)->pluck('room_number', 'id');
        return view('assessment.evaluate', ['assessment' => $assessment, 'rooms' => $rooms, 'inventories' => $inventories]);
    }

    public function fetchChecklistTypes(Request $request)
    {
        $section = Section::find($request->assessment_section_id);
        return response()->json(['checklist_types' => $section->checklistTypes]);
    }
}
