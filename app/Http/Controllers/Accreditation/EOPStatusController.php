<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Site;
use App\Regulatory\HCO;
use App\Regulatory\EOP;
use App\Regulatory\Building;
use App\Regulatory\HealthSystem;
use App\Regulatory\AccreditationRequirement;
use Session;

class EOPStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index($eop_id)
    {
        $eop = EOP::find($eop_id);
        $building = Building::find(session('building_id'));
        return view('accreditation.status',['eop' => $eop,'building' => $building]);
    }

}
