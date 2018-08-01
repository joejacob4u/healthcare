<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\UtilityFunction;

class UtilityFunctionsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('master');
    }

    public function index()
    {
        return view('maintenance.utility-functions', ['utility_functions' => UtilityFunction::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:maintenance_utility_functions,name',
            'score' => 'required|numeric'
        ]);

        if (UtilityFunction::create($request->all())) {
            return back()->with('success', 'Utility Function created!');
        }
    }

    public function delete(Request $request)
    {
        UtilityFunction::destroy($request->id);
        return 'true';
    }
}
