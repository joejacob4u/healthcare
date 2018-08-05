<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\AssetCategory;
use App\Maintenance\Category;
use App\Regulatory\Accreditation;
use App\Regulatory\StandardLabel;
use App\Regulatory\EOP;

class AssetCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index($category_id)
    {
        $category = Category::find($category_id);
        return view('maintenance.asset-category.index', ['category' => $category]);
    }

    public function create($category_id)
    {
        $accreditations = Accreditation::pluck('name', 'id');
        $category = Category::find($category_id);
        return view('maintenance.asset-category.add', ['accreditations' => $accreditations,'category' => $category]);
    }

    public function store(Request $request, $category_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'required_by' => 'not_in:0|required',
            'service_life' => 'required|numeric',
            'eop_id' => 'required|not_in:0'
        ]);

        $category = Category::find($category_id);

        if ($asset_category = $category->assetCategories()->create($request->except(['accreditation_id','standard_label_id','eop_id']))) {
            $asset_category->eops()->sync($request->eop_id);
            return redirect('admin/maintenance/categories/'.$category_id.'/asset-categories')->with('success', 'Asset Category created!');
        }
    }

    public function edit($category_id, $asset_category_id)
    {
        $asset_category = AssetCategory::find($asset_category_id);
        $accreditations = Accreditation::pluck('name', 'id');
        
        $standard_label_ids = [];
        $accreditation_ids = [];

        foreach ($asset_category->eops as $eop) {
            $standard_label_ids[] = $eop->standardLabel->id;
            $accreditation_ids[] = $eop->standardLabel->accreditation_id;
        }

        $standard_labels = StandardLabel::whereIn('accreditation_id', $accreditation_ids)->pluck('label', 'id');
        $eops = EOP::whereIn('standard_label_id', $standard_label_ids)->pluck('name', 'id');
        return view('maintenance.asset-category.edit', ['asset_category' => $asset_category,'standard_labels' => $standard_labels,'accreditations' => $accreditations,'standard_label_ids' => $standard_label_ids,'accreditation_ids' => $accreditation_ids,'eops' => $eops]);
    }

    public function save(Request $request, $category_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'required_by' => 'not_in:0|required',
            'service_life' => 'required|numeric',
            'eop_id' => 'required|not_in:0'
        ]);

        $asset_category = AssetCategory::find($request->asset_category_id);

        if ($asset_category->update($request->except(['asset_category_id','accreditation_id','standard_label_id','eop_id']))) {
            $asset_category->eops()->sync($request->eop_id);
            return redirect('admin/maintenance/categories/'.$category_id.'/asset-categories')->with('success', 'Asset Category saved!');
        }
    }

    public function delete(Request $request)
    {
        AssetCategory::destroy($request->id);
        return 'true';
    }
}
