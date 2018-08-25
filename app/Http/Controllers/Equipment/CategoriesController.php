<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master')->except('assetCategories');
        $this->middleware('system_admin')->only('assetCategories');
    }

    public function index()
    {
        return view('equipment.category', ['categories' => Category::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:equipment_categories,name'
        ]);

        if (Category::create($request->all())) {
            return back()->with('success', 'Category created!');
        }
    }

    public function assetCategories(Request $request)
    {
        $category = Category::find($request->category_id);
        return response()->json(['asset_categories' => $category->assetCategories]);
    }

    public function delete(Request $request)
    {
        Category::destroy($request->id);
        return 'true';
    }
}
