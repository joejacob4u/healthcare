<?php

namespace App\Http\Controllers\Admin\Rounding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rounding\ChecklistType;

class ChecklistTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $checklist_types = ChecklistType::get();
        return view('admin.rounding.checklist-type', ['checklist_types' => $checklist_types]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if (ChecklistType::create($request->all())) {
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
