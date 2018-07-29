<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('maintenance.category', ['categories' => Category::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:maintenance_categories,name'
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
