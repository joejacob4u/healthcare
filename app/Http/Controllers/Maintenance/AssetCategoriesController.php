<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\AssetCategory;

class AssetCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('maintenance.asset-category', ['asset_categories' => AssetCategory::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:maintenance_asset_categories,name'
        ]);

        if (AssetCategory::create($request->all())) {
            return back()->with('success', 'Asset Category created!');
        }
    }

    public function delete(Request $request)
    {
        AssetCategory::destroy($request->id);
        return 'true';
    }
}
