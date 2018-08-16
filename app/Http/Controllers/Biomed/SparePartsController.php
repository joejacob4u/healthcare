<?php

namespace App\Http\Controllers\Biomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Biomed\SparePart;

class SparePartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('biomed.spare-part', ['spare_parts' => SparePart::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:biomed_spare_parts,name',
        ]);

        if (SparePart::create($request->all())) {
            return back()->with('success', 'Spare Part created!');
        }
    }

    public function delete(Request $request)
    {
        SparePart::destroy($request->id);
        return 'true';
    }
}
