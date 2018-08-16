<?php

namespace App\Http\Controllers\Biomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Biomed\CurrentState;

class CurrentStatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        return view('biomed.current-state', ['current_states' => CurrentState::get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:biomed_current_states,name',
        ]);

        if (CurrentState::create($request->all())) {
            return back()->with('success', 'Current State created!');
        }
    }

    public function delete(Request $request)
    {
        CurrentState::destroy($request->id);
        return 'true';
    }
}
