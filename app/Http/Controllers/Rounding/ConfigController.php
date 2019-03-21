<?php

namespace App\Http\Controllers\Rounding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rounding\Config;
use App\Regulatory\BuildingDepartment;
use App\Rounding\ChecklistType;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $configs = Config::where('building_id', session('building_id'))->paginate('15');
        return view('rounding.config.index', ['configs' => $configs]);
    }

    public function create()
    {
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id');
        $checklist_types = ChecklistType::pluck('name', 'id');
        return view('rounding.config.add', ['departments' => $departments, 'checklist_types' => $checklist_types]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'building_department_id' => 'required',
            'rounding_checklist_type_id' => 'required',
            'frequency' => 'required',
            'baseline_date' => 'required'
        ]);

        if (Config::create($request->all())) {
            return redirect('rounding/config')->with('success', 'Config created');
        }
    }

    public function edit(Config $config)
    {
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id');
        $checklist_types = ChecklistType::pluck('name', 'id');
        return view('rounding.config.edit', ['config' => $config,'departments' => $departments, 'checklist_types' => $checklist_types]);
    }

    public function update(Request $request, Config $config)
    {
        $this->validate($request, [
            'building_department_id' => 'required',
            'rounding_checklist_type_id' => 'required',
            'frequency' => 'required',
            'baseline_date' => 'required'
        ]);

        if ($config->update($request->all())) {
            return redirect('rounding/config')->with('success', 'Config updated');
        }
    }

    public function destroy(Request $request)
    {
        if (Config::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
