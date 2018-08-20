<?php

namespace App\Http\Controllers\Biomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Biomed\EquipmentUser;

class EquipmentUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipment_users = EquipmentUser::get();
        return view('biomed.equipment-user', ['equipment_users' => $equipment_users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:biomed_equipment_users,name',
        ]);

        if (EquipmentUser::create($request->all())) {
            return back()->with('success', 'Equipment User created!');
        }
    }

    public function delete(Request $request)
    {
        EquipmentUser::destroy($request->id);
        return 'true';
    }
}
