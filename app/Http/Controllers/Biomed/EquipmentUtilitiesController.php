<?php

namespace App\Http\Controllers\Biomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Biomed\EquipmentUtility;

class EquipmentUtilitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('biomed.equipment-utility', ['equipment_utilities' => EquipmentUtility::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'percentage' => 'required|unique:biomed_equipment_utilizations,percentage',
        ]);

        if (EquipmentUtility::create($request->all())) {
            return back()->with('success', 'Equipment Utility created!');
        }
    }

    public function delete(Request $request)
    {
        EquipmentUtility::destroy($request->id);
        return 'true';
    }
}
