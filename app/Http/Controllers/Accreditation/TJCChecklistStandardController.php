<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\TJCChecklistStandard;

class TJCChecklistStandardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $standard_labels = StandardLabel::select('id', 'label', 'text')->get();
        $tjc_standard_labels = TJCChecklistStandard::latest()->get();
        return view('tjc.standards.index', ['standard_labels' => $standard_labels,'tjc_standard_labels' => $tjc_standard_labels]);
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'standard_label_id' => 'not_in:0'
        ]);

        if (TJCChecklistStandard::create($request->all())) {
            return back()->with('success', 'New standard added !');
        }
    }

    public function destroy(Request $request)
    {
        if (TJCChecklistStandard::destroy($request->tjc_checklist_standard_id)) {
            return 'true';
        }
    }

    /**
     * fetchEOPs - fetches eops for a given standard label
     *
     * @param Request $request
     * @return void
     */
    public function fetchEOPs(Request $request)
    {
        $standard_label = StandardLabel::find($request->standard_label_id);
        return response()->json($standard_label->eops);
    }
}
