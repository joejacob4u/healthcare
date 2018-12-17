<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Equipment;

class BaselineDateController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($equipment_id)
    {
        return view('equipment.baseline.index', ['equipment' => Equipment::find($equipment_id)]);
    }

    public function store(Request $request, $equipment_id)
    {
        $this->validate($request, [
            'date' => 'required'
        ]);

        $equipment = Equipment::find($equipment_id);

        if ($equipment->baselineDates()->create($request->all())) {
            return back()->with('success', 'Baseline created.');
        }
    }
}
