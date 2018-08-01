<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\PhysicalRisk;

class PhysicalRisksController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('maintenance.physical-risks', ['physical_risks' => PhysicalRisk::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:maintenance_physical_risks,name',
            'score' => 'required|numeric'
        ]);

        if (PhysicalRisk::create($request->all())) {
            return back()->with('success', 'Physical risk created!');
        }
    }

    public function delete(Request $request)
    {
        PhysicalRisk::destroy($request->id);
        return 'true';
    }
}
