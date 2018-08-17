<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\IncidentHistory;

class IncidentHistoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }
    public function index()
    {
        $incident_histories = IncidentHistory::get();
        return view('equipment.incident-history', ['incident_histories' => $incident_histories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:equipment_incident_histories,name',
            'score' => 'required|numeric'
        ]);

        if (IncidentHistory::create($request->all())) {
            return back()->with('success', 'Incident history created!');
        }
    }

    public function delete(Request $request)
    {
        IncidentHistory::destroy($request->id);
        return 'true';
    }
}
