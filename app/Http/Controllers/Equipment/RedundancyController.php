<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Redundancy;

class RedundancyController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }
    public function index()
    {
        $redundancies = Redundancy::get();
        return view('equipment.redundancy', ['redundancies' => $redundancies]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:maintenance_redundancies,name',
            'score' => 'required|numeric'
        ]);

        if (Redundancy::create($request->all())) {
            return back()->with('success', 'Redundancy created!');
        }
    }

    public function delete(Request $request)
    {
        Redundancy::destroy($request->id);
        return 'true';
    }
}
