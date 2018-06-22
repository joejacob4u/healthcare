<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Building;
use App\Regulatory\BuildingDepartment;

class DepartmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($site_id, $building_id)
    {
        $building = Building::find($building_id);
        return view('admin.healthsystem.departments.index', ['building' => $building]);
    }

    public function add($building_id)
    {
        $building = Building::find($building_id);
        return view('admin.healthsystem.departments.add', ['building' => $building]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'business_unit_cost_center' => 'required'
        ]);

        if (BuildingDepartment::create($request->all())) {
            return back()->with('success', 'New department created!');
        }
    }

    public function edit($building_id, $department_id)
    {
        $department = BuildingDepartment::find($department_id);
        return view('admin.healthsystem.departments.edit', ['department' => $department]);
    }

    public function save(Request $request, $building_id, $department_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'business_unit_cost_center' => 'required'
        ]);

        $department = BuildingDepartment::find($department_id);

        if ($department->update($request->all())) {
            return back()->with('success', 'Department updated!');
        }
    }

    public function delete(Request $request)
    {
        if (BuildingDepartment::destroy($request->department_id)) {
            return 'true';
        }
    }
}
