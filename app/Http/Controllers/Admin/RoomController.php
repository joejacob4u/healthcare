<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\BuildingDepartment;
use App\Regulatory\Room;

class RoomController extends Controller
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
    public function index($building_id, $department_id)
    {
        $department = BuildingDepartment::find($department_id);
        return view('admin.healthsystem.rooms.index', ['department' => $department]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($department_id)
    {
        $department = BuildingDepartment::find($department_id);
        return view('admin.healthsystem.rooms.add', ['department' => $department]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'room_number' => 'required',
            'room_type' => 'required',
            'is_clinical' => 'required|not_in:-1',
            'square_ft' => 'required|numeric',
            'bar_code' => 'nullable|numeric',
            'sprinkled_pct' => 'required',
            'beds' => 'required|numeric',
            'unused_space_sq_ft' => 'required|numeric',
            'operating_rooms' => 'required|numeric'
        ]);

        if ($room = Room::create($request->all())) {
            return redirect('admin/buildings/'.$room->buildingDepartment->building->id.'/departments/'.$request->department_id.'/rooms')->with('success', 'New Room Created!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($department_id, $room_id)
    {
        $room = Room::find($room_id);
        return view('admin.healthsystem.rooms.edit', ['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $department_id, $room_id)
    {
        $this->validate($request, [
            'room_number' => 'required',
            'room_type' => 'required',
            'is_clinical' => 'required|not_in:-1',
            'square_ft' => 'required|numeric',
            'bar_code' => 'nullable|numeric',
            'sprinkled_pct' => 'required',
            'beds' => 'required||numeric',
            'unused_space_sq_ft' => 'required|numeric',
            'operating_rooms' => 'required|numeric'
        ]);

        $room = Room::find($room_id);

        if ($room->update($request->all())) {
            return back()->with('success', 'Room Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Room::destroy($request->room_id)) {
            return 'true';
        }
    }
}
