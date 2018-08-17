<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\PhysicalRisk;

class PhysicalRisksController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('equipment.physical-risks', ['physical_risks' => PhysicalRisk::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:equipment_physical_risks,name',
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
