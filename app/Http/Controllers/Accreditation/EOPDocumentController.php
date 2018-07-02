<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\EOPDocumentComment;
use App\Regulatory\EOPDocument;
use App\Regulatory\EOPDocumentSubmissionDate;
use App\Regulatory\EOP;
use App\User;
use Auth;
use Carbon\Carbon;
use Storage;
use App\Regulatory\EOPFinding;

class EOPDocumentController extends Controller
{

    /**
     * __construct - users only!
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('user');
    }

    
    /**
     * index - show docuemnts index page
     *
     * @param mixed $eop_id
     * @return void
     */


    public function index($eop_id, $submission_date_id)
    {
        $eop = EOP::find($eop_id);
        $submission_date = EOPDocumentSubmissionDate::find($submission_date_id);
        $tolerant_dates = $submission_date->getTolerantUploadDates();
        return view('accreditation.eop_documents.documents.index', ['submission_date' => $submission_date,'eop' => $eop,'tolerant_dates' => $tolerant_dates]);
    }

    /**
     * create - brings up GUI for document upload
     *
     * @return view
     */

    public function create($eop_id, $submission_date_id)
    {
        $submission_date = EOPDocumentSubmissionDate::find($submission_date_id);
        return view('accreditation.eop_documents.documents.add', ['submission_date' => $submission_date,'tolerance_dates' => $submission_date->getTolerantUploadDates()]);
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
        $this->validate($request, [
            'document_path' => 'required',
            'document_date' => 'unique:eop_documents,document_date|required'
        ]);

        $no_of_files = count(Storage::disk('s3')->files($request->document_path));
        
        if ($no_of_files > 0) {
            if ($document = EOPDocument::create($request->all())) {
                $this->validateDocumentDate($document);
                $document->submissionDate()->update(['status' => 'pending_verification']);
                return redirect('system-admin/accreditation/eop/'.$document->submissionDate->eop->id.'/submission_date/'.$document->eop_document_submission_date_id.'/documents')->with('success', 'Document created!');
            }
        } else {
            return back()->with('warning', 'You must upload one or more files.');
        }
    }

    /**
     * edit - renders edit form for document
     *
     * @param mixed $document_id
     * @return void
     */


    public function edit($eop_id, $submission_date_id, $document_id)
    {
        $document = EOPDocument::find($document_id);
        $submission_date = EOPDocumentSubmissionDate::find($submission_date_id);
        return view('accreditation.eop_documents.documents.edit', ['document' => $document,'submission_date' => $submission_date]);
    }

    /**
     * save - saves edit form request
     *
     * @param mixed $document_id
     * @return void
     */


    public function save(Request $request, $document_id)
    {
        $this->validate($request, [
            'document_path' => 'required',
            'document_date' => 'required'
        ]);

        $document = EOPDocument::find($document_id);

        if ($document->update($request->all())) {
            return redirect('system-admin/accreditation/eop/'.$document->eop_id.'/documents')->with('success', 'Document Saved!');
        }
    }

    /**
     * verify - allows a verifier to mark compliant or not
     *
     * @param Request $request
     * @return void
     */
    public function verify(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        if (EOPDocumentComment::create($request->except(['status']))) {
            $document = EOPDocument::find($request->eop_document_id);
            if ($document->update(['status' => $request->status])) {
                if ($document->submissionDate()->update(['status' => $request->status])) {
                    return back()->with('success', 'Marked as '.$request->status);
                }
            }
        }
    }

    /**
     * validateDocumentDate - adds a finding if date is not between the tolerance dates
     *
     * @param EOPDocument $document
     * @return void
     */
    private function validateDocumentDate(EOPDocument $document)
    {
        $tolerant_dates = $document->submissionDate->getTolerantUploadDates();

        if (Carbon::parse($document->document_date)->greaterThan(Carbon::parse($tolerant_dates['end']))) {
            // $finding = new EOPFinding;
            // $finding->building_id = session('building_id');
            // $finding->eop_id = $document->submissionDate->eop->id;
            // $finding->accreditation_id = session('accreditation_id');
            // $finding->description = 'A document was not uploaded to comply with '.$document->submissionDate->eop->standardLabel->label.' - '.$document->submissionDate->eop->standardLabel->text.' [EOP] '.$document->submissionDate->eop->name.' [Frequency] '.$document->submissionDate->eop->frequency;
            // $finding->location = 'n/a';
            // $finding->plan_of_action = 'Upload document(s) to reflect compliance.';
            // $finding->measure_of_success = 'Uploaded documents that correct/comply with the finding description and are dated on or before the required date as noted in the measure of success date.';
            // $finding->measure_of_success_date = $tolerant_dates['end'];
            // $finding->internal_notes = 'n/a';
            // $finding->benefit = 'Compliance with TJC Standards and EOPs';
            // $finding->activity = 'Constant State of Readiness Review';
            // $finding->attachments_path = 'accreditation/'.session('accreditation_id').'/building/'.session('building_id').'/eop/'.$document->submissionDate->eop->id.'/finding/'.time();
            // $finding->documents_description = '';
            // $finding->status = 'initial';
            // $finding->save();
        }
    }
}
