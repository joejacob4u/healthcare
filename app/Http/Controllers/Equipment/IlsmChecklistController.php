<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Ilsm;
use App\Equipment\IlsmChecklist;

class IlsmChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index($ilsm_id)
    {
        $ilsm = Ilsm::find($ilsm_id);
        return view('admin.ilsm.checklist.index', ['ilsm' => $ilsm]);
    }

    public function store(Request $request, $ilsm_id)
    {
        $this->validate($request, [
            'question' => 'required'
        ]);

        $ilsm = Ilsm::find($ilsm_id);

        if ($ilsm->checklists()->create($request->all())) {
            return back()->with('success', 'New checklist created.');
        }
    }

    public function delete(Request $request)
    {
        $ilsm_checklist = IlsmChecklist::find($request->ilsm_checklist_id);

        if ($ilsm_checklist->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
