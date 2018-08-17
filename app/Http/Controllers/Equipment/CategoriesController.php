<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
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

    public function delete(Request $request)
    {
        Category::destroy($request->id);
        return 'true';
    }
}
