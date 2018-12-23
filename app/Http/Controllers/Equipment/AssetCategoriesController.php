<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\AssetCategory;
use App\Equipment\Category;
use App\Regulatory\Accreditation;
use App\Regulatory\StandardLabel;
use App\Regulatory\EOP;
use App\Equipment\PhysicalRisk;
use App\Equipment\UtilityFunction;
use App\SystemTier;

class AssetCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index($category_id)
    {
        $category = Category::find($category_id);
        return view('equipment.asset-category.index', ['category' => $category]);
    }

    public function create($category_id)
    {
        $accreditations = Accreditation::pluck('name', 'id');
        $eops = EOP::get(['name', 'text', 'id'])->pluck('full_name', 'id')->prepend('Please select', 0);
        $category = Category::find($category_id);
        $physical_risks = PhysicalRisk::orderBy('score', 'desc')->pluck('name', 'id')->prepend('Please select', 0);
        $utility_functions = UtilityFunction::orderBy('score', 'desc')->pluck('name', 'id')->prepend('Please select', 0);
        $system_tiers = SystemTier::pluck('name', 'id');
        return view('equipment.asset-category.add', ['accreditations' => $accreditations,'category' => $category,'physical_risks' => $physical_risks,'utility_functions' => $utility_functions,'eops' => $eops,'system_tiers' => $system_tiers]);
    }

    public function store(Request $request, $category_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'required_by' => 'not_in:0|required',
            'service_life' => 'required|numeric',
            'equipment_physical_risk_id' => 'required|exists:equipment_physical_risks,id',
            'equipment_utility_function_id' => 'required|exists:equipment_utility_functions,id',
            'system_tier_id' => 'not_in:0'
        ]);

        $category = Category::find($category_id);

        if ($asset_category = $category->assetCategories()->create($request->except(['accreditation_id','standard_label_id','eop_id']))) {
            if (!empty($request->eop_id)) {
                $asset_category->eops()->sync($request->eop_id);
            }
            return redirect('admin/equipment/categories/'.$category_id.'/asset-categories')->with('success', 'Asset Category created!');
        }
    }

    public function edit($category_id, $asset_category_id)
    {
        $asset_category = AssetCategory::find($asset_category_id);
        $physical_risks = PhysicalRisk::orderBy('score', 'desc')->pluck('name', 'id')->prepend('Please select', 0);
        $utility_functions = UtilityFunction::orderBy('score', 'desc')->pluck('name', 'id')->prepend('Please select', 0);
        $system_tiers = SystemTier::pluck('name', 'id');

        $eops = EOP::get(['name', 'text', 'id'])->pluck('full_name', 'id');
        return view('equipment.asset-category.edit', ['asset_category' => $asset_category,'eops' => $eops,'physical_risks' => $physical_risks,'utility_functions' => $utility_functions,'system_tiers' => $system_tiers]);
    }

    public function save(Request $request, $category_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'required_by' => 'not_in:0|required',
            'service_life' => 'required|numeric',
            'equipment_physical_risk_id' => 'required|exists:equipment_physical_risks,id',
            'equipment_utility_function_id' => 'required|exists:equipment_utility_functions,id',
            'system_tier_id' => 'not_in:0'
        ]);

        $asset_category = AssetCategory::find($request->asset_category_id);

        if ($asset_category->update($request->except(['asset_category_id','accreditation_id','standard_label_id','eop_id']))) {
            if (!empty($request->eop_id)) {
                $asset_category->eops()->sync($request->eop_id);
            }
            return redirect('admin/equipment/categories/'.$category_id.'/asset-categories')->with('success', 'Asset Category saved!');
        }
    }

    public function delete(Request $request)
    {
        AssetCategory::destroy($request->id);
        return 'true';
    }
}
