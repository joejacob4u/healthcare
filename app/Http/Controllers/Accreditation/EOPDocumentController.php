<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\EOPDocument;
use App\Regulatory\EOP;
use Storage;

class EOPDocumentController extends Controller
{

    /**
     * __construct - only system - admins!
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('system_admin');
    }

    
    /**
     * index - show docuemnts index page
     *
     * @param mixed $eop_id
     * @return void
     */


    public function index($eop_id)
    {
        $eop = EOP::find($eop_id);
        $documents = EOPDocument::whereHas('buildings', function($q) { $q->where('id',session('building_id')); } )->where('eop_id',$eop->id)->get();
        return view('accreditation.eop_documents.index',['documents' => $documents,'eop' => $eop]);
    }

    /**
     * store - stores value from the document 
     *         upload form 
     *
     * @param Request $request - post data
     * 
     * @return void
     */


    public function store(Request $request)
    {
        $this->validate($request,[
            'document_path' => 'required',
            'document_date' => 'required'
        ]);

        $no_of_files = count(Storage::disk('s3')->files($request->document_path));
        
        if($no_of_files > 0)
        {
            if($document = EOPDocument::create($request->all()))
            {
                $document->buildings()->attach(session('building_id'));
                return back()->with('success','Document created!');
            }
        }
        else
        {
            return back()->with('warning','You must upload one or more files.');
        }

    }

    /**
     * edit - renders edit form for document
     *
     * @param mixed $document_id
     * @return void
     */


    public function edit($document_id)
    {
        $document = EOPDocument::find($document_id);
        return view('accreditation.eop_documents.edit',['document' => $document]);
    }

    /**
     * save - saves edit form request
     *
     * @param mixed $document_id
     * @return void
     */


    public function save(Request $request,$document_id)
    {
        $this->validate($request,[
            'document_path' => 'required',
            'document_date' => 'required'
        ]);

        $document = EOPDocument::find($document_id);

        if($document->update($request->all()))
        {
            return redirect('system-admin/accreditation/eop/'.$document->eop_id.'/documents')->with('success','Document Saved!');
        }
    }
}
