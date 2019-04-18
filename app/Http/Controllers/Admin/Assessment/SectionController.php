<?php

namespace App\Http\Controllers\Admin\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Assessment\Section;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $sections = Section::get();
        return view('admin.assessment.section', ['sections' => $sections]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if (Section::create($request->all())) {
            return back()->with('success', 'New Section Created');
        }
    }

    public function destroy(Request $request)
    {
        if (Section::find($request->id)->delete()) {
                return response()->json(['status' => 'success']);
            }
    }
}
