<?php

namespace App\Http\Controllers\Admin\Rounding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rounding\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $categories = Category::get();
        return view('admin.rounding.categories', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:rounding_categories,name'
        ]);

        if (Category::create($request->all())) {
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
