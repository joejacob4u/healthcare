<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\EOPDocumentSubmissionDate;
use App\Regulatory\EOPDocument;
use App\Regulatory\EOP;
use App\User;

class EOPSubmissionDateController extends Controller
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
    public function index($eop_id)
    {
        $eop = EOP::find($eop_id);
        $submission_dates = EOPDocumentSubmissionDate::where('eop_id', $eop->id)->where('building_id', session('building_id'))->get();
        return view('accreditation.eop_documents.index', ['eop' => $eop, 'submission_dates' => $submission_dates]);
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
        if ($submission_date = EOPDocumentSubmissionDate::create($request->all())) {
            return redirect('system-admin/accreditation/eop/'.$request->eop_id.'/submission_date/'.$submission_date->id.'/documents')->with('success', 'You can now start submitting documents down below.');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (EOPDocumentSubmissionDate::destroy($request->id)) {
            return 'true';
        }
    }
}
