<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accreditation;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\EOP;
use App\Regulatory\Building;
use App\Regulatory\HealthSystem;
use App\Regulatory\AccreditationRequirement;
use App\Regulatory\EOPDocumentBaselineDate;
use App\Regulatory\EOPDocumentSubmissionDate;
use Session;
use Auth;

class AccreditationController extends Controller
{
    public function __construct()
    {
        $this->middleware('user')->except(['fetchManyStandardLabels','setAccreditationRequirement']);
        $this->middleware('master')->only('fetchManyStandardLabels');
    }

    public function index()
    {
        $hcos = HCO::where('healthsystem_id', Auth::guard('system_user')->user()->healthSystem->id)->pluck('facility_name', 'id')->prepend('Please select a hco', '0');
        return view('accreditation.index', ['hcos' => $hcos]);
    }

    public function fetchStandardLabels($accreditation_id, $accreditation_requirement_id)
    {
        $building = Building::find(session('building_id'));
        $accreditation = Accreditation::find($accreditation_id);
        
        $accreditation_requirement = AccreditationRequirement::find($accreditation_requirement_id);

        $standard_labels = AccreditationRequirement::whereHas('accreditations', function ($query) use ($accreditation) {
            $query->where('id', $accreditation->id);
        })
        ->find($accreditation_requirement_id)->standardLabels;


        Session::put('accreditation_id', $accreditation_id);
        Session::put('accreditation_requirement_id', $accreditation_requirement_id);

        return view('accreditation.index', ['accreditation' => $accreditation,'accreditation_requirement' => $accreditation_requirement,'building' => $building,'standard_labels' => $standard_labels]);
    }

    public function fetchBuildings(Request $request)
    {
        $site = Site::find($request->site_id);

        return response()->json(['buildings' => $site->buildings]);
    }

    public function setBuilding(Request $request)
    {
        $this->validate($request, [
            'building_id' => 'required|not_in:0',
        ]);

        $building = Building::find($request->building_id);
        $hco = HCO::find($request->hco_id);
        $site = Site::find($request->site_id);
        
        Session::put('building_id', $request->building_id);
        Session::put('site_id', $request->site_id);
        Session::put('hco_id', $request->hco_id);
        Session::put('building_name', $building->name);
        Session::put('site_name', $site->name);
        Session::put('hco_name', $hco->facility_name);


        return redirect('accreditation/dashboard');
    }

    public function fetchSites(Request $request)
    {
        $hco = HCO::find($request->hco_id);
        return response()->json(['sites' => $hco->sites]);
    }

    public function fetchAccreditations(Request $request)
    {
        $building = Building::find($request->building_id);
        return response()->json(['accreditations' => $building->accreditations]);
    }

    public function fetchAccreditationRequirements(Request $request)
    {
        $accreditation = Accreditation::find($request->accreditation_id);
        return response()->json(['accreditation_requirements' => $accreditation->accreditationRequirements]);
    }

    public function eopDocumentation($eop_id)
    {
        $building = Building::find(session('building_id'));
        $eop = EOP::find($eop_id);
        $last_submission = $eop->getLastDocumentUpload(session('building_id'));
        return view('accreditation.documentation', ['building' => $building,'eop' => $eop]);
    }

    public function uploadEOPDocument(Request $request)
    {
        $this->validate($request, [
            'submission_date' => 'required',
        ]);

        $building = Building::find($request->building_id);

        $building->eopDocumentations()->attach([$request->eop_id => ['accreditation_id' => $request->accreditation_id, 'document_path' => $request->document_path, 'submission_date' => $request->submission_date,'submitted_on' => $request->submitted_on, 'user_id' => $request->user_id]]);
        return back()->with('success', 'Document Added!');
    }

    public function saveBaselineDate(Request $request)
    {
        $this->validate($request, [
            'baseline_date' => 'required_unless:is_baseline_disabled,==,1',
            'comment' => 'required_if:is_baseline_disabled,==,1',
        ]);


        if ($request->is_baseline_disabled === null) {
            $request->is_baseline_disabled = 0;
        }

        EOPDocumentSubmissionDate::where('eop_id', $request->eop_id)->where('building_id', session('building_id'))->where('accreditation_id', $request->accreditation_id)->delete();

        $eop = EOP::find($request->eop_id);

        EOPDocumentBaselineDate::where('eop_id', $eop->id)->where('building_id', session('building_id'))->where('accreditation_id', session('accreditation_id'))->delete();

        EOPDocumentBaselineDate::updateOrCreate(
            ['eop_id' => $request->eop_id, 'building_id' => session('building_id'),
            'baseline_date' => $request->baseline_date,'comment' => $request->comment,'is_baseline_disabled' => $request->is_baseline_disabled,'accreditation_id' => $request->accreditation_id,'accreditation_requirement_id' => session('accreditation_requirement_id')]
        );

        if (!$request->is_baseline_disabled) {
            foreach ($eop->calculateDocumentDates($request->baseline_date) as $date) {
                EOPDocumentSubmissionDate::create(['accreditation_id' => session('accreditation_id'),'eop_id' => $eop->id,'building_id' => session('building_id'),'submission_date' => $date,'status' => 'pending_upload','user_id' => Auth::user()->id,'accreditation_requirement_id' => $request->accreditation_requirement_id]);
            }
        }


        //EOPDocumentSubmissionDate::where('eop_id', $request->eop_id)->where('building_id', session('building_id'))->where('accreditation_id', $request->accreditation_id)->delete();

        return back()->with('success', 'Baseline Date saved!');
    }

    public function fetchManyStandardLabels(Request $request)
    {
        $standard_labels = [];
        $accreditation_ids = json_decode($request->accreditations);

        foreach ($accreditation_ids as $accreditation_id) {
            $accreditation = Accreditation::find($accreditation_id);

            foreach ($accreditation->standardLabels as $standard_label) {
                $standard_labels[] = $standard_label;
            }
        }

        return response()->json(['standard_labels' => $standard_labels]);
    }

    public function setAccreditationRequirement(Request $request)
    {
        Session::put('accreditation_requirement_id', $request->accreditation_requirement_id);
    }
}
