<?php

namespace App\Http\Controllers\Admin\Tracer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tracer\ChecklistType;
use App\Regulatory\Accreditation;
use App\Tracer\Section;

class ChecklistTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index(Section $section)
    {
        $accreditations = Accreditation::pluck('name', 'id');
        return view('admin.tracer.checklist-type', ['section' => $section, 'accreditations' => $accreditations]);
    }

    public function store(Request $request, Section $section)
    {
        $this->validate($request, [
            'name' => 'required',
            'accreditations' => 'required'
        ]);

        if ($checklist_type = $section->checklistTypes()->create($request->all())) {
            $checklist_type->accreditations()->sync($request->accreditations);
            return back()->with('success', 'New checklist type created.');
        }
    }

    public function save(Request $request, Section $section)
    {
        $this->validate($request, [
            'name' => 'required',
            'accreditations' => 'required'
        ]);

        $checklist_type = ChecklistType::find($request->checklist_type_id);

        if ($checklist_type->update($request->all())) {
            $checklist_type->accreditations()->sync($request->accreditations);
            return back()->with('success', 'Checklist type updated.');
        }
    }

    public function destroy(Request $request)
    {
        if (ChecklistType::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
