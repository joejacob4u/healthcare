<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\AssetCategory;
use App\Maintenance\Category;

class AssetCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index($category_id)
    {
        $category = Category::find($category_id);
        return view('maintenance.asset-category', ['category' => $category]);
    }

    public function store(Request $request, $category_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'required_by' => 'not_in:0|required',
            'service_life' => 'required|numeric'
        ]);

        $category = Category::find($category_id);

        if ($category->assetCategories()->create($request->all())) {
            return back()->with('success', 'Asset Category created!');
        }
    }

    public function save(Request $request, $category_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'required_by' => 'not_in:0|required',
            'service_life' => 'required|numeric'
        ]);

        $asset_category = AssetCategory::find($request->asset_category_id);

        if ($asset_category->update($request->except(['asset_category_id']))) {
            return back()->with('success', 'Asset Category saved!');
        }
    }

    public function delete(Request $request)
    {
        AssetCategory::destroy($request->id);
        return 'true';
    }
}
