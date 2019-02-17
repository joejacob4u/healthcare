<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Ilsm;

class IlsmController extends Controller
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
        $ilsms = Ilsm::get();
        return view('equipment.ilsm.index', ['ilsms' => $ilsms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'label' => 'required|unique:ilsms,label',
            'description' => 'required'
        ]);

        if (Ilsm::create($request->all())) {
            return back()->with('success', 'New ILSM created.');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'description' => 'required'
        ]);

        $ilsm = Ilsm::find($request->ilsm_id);

        if ($ilsm->update($request->all())) {
            return back()->with('success', 'ILSM updated.');
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
        $ilsm = Ilsm::find($request->ilsm_id);

        if ($ilsm->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
