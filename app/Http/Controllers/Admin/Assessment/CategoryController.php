<?php

namespace App\Http\Controllers\Admin\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Assessment\Category;
use App\Assessment\ChecklistType;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index(ChecklistType $checklist_type)
    {
        $categories = Category::get();
        return view('admin.assessment.categories', ['checklist_type' => $checklist_type]);
    }

    public function store(Request $request, ChecklistType $checklist_type)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if ($checklist_type->categories()->create($request->all())) {
            return back()->with('success', 'New Category created !');
        }
    }

    public function destroy(Request $request)
    {
        if (Category::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
