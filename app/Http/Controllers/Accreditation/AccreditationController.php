<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Accreditation;
use App\Regulatory\AccreditationRequirement;
use Session;

class AccreditationController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($accreditation_id)
    {
        Session::put('accreditation_id', $accreditation_id);
        $accreditation = Accreditation::find($accreditation_id);
        return view('accreditation.index',['accreditation' => $accreditation]);

    }

    public function fetchAccrRequirements(Request $request,$accreditation_id)
    {
        $accreditation = Accreditation::find($accreditation_id);
        $accreditation_requirement = AccreditationRequirement::find($request->accreditation_requirement_id);
        return view('accreditation.index',['accreditation' => $accreditation,'accreditation_requirement' => $accreditation_requirement]);
    }

}
