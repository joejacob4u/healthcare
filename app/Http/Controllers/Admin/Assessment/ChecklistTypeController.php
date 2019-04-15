<?php

namespace App\Http\Controllers\Admin\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Assessment\ChecklistType;
use App\Regulatory\Accreditation;

class ChecklistTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $checklist_types = ChecklistType::get();
        $accreditations = Accreditation::pluck('name', 'id');
        return view('admin.assessment.checklist-type', ['checklist_types' => $checklist_types, 'accreditations' => $accreditations]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'accreditations' => 'required'
        ]);

        if ($checklist_type = ChecklistType::create($request->all())) {
            $checklist_type->accreditations()->sync($request->accreditations);
            return back()->with('success', 'New checklist type created.');
        }
    }

    public function destroy(Request $request)
    {
        if (ChecklistType::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
