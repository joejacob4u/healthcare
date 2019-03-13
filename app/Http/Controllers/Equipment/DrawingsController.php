<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Drawing;
use App\Equipment\DrawingCategory;
use Storage;

class DrawingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drawings = Drawing::where('building_id', session('building_id'))->get();
        return view('equipment.drawing.index', ['drawings' => $drawings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DrawingCategory::pluck('name', 'id');
        return view('equipment.drawing.add', ['categories' => $categories]);
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
            'name' => 'required',
            'facility_maintenance_drawing_category_id' => 'required',
            'date' => 'required'
        ]);

        if (count(Storage::disk('s3')->files($request->attachment_dir)) < 1) {
            return back()->with('warning', 'You need to add atleast one attachment.');
        }

        if (Drawing::create($request->all())) {
            return back()->with('success', 'Drawing added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Drawing $drawing)
    {
        $categories = DrawingCategory::pluck('name', 'id');
        return view('equipment.drawing.edit', ['categories' => $categories,'drawing' => $drawing]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drawing $drawing)
    {
        $this->validate($request, [
            'name' => 'required',
            'facility_maintenance_drawing_category_id' => 'required',
            'date' => 'required'
        ]);

        if (count(Storage::disk('s3')->files($request->attachment_dir)) < 1) {
            return back()->with('warning', 'You need to add atleast one attachment.');
        }

        if ($drawing->update($request->all())) {
            return back()->with('success', 'Drawing updated!');
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
        if (Drawing::find($request->id)->delete()) {
            return response()->json(['status' =>'success']);
        }
    }
}
