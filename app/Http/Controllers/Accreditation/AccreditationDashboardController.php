<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;

class AccreditationDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $hco = HCO::find(session('hco_id'));
        return view('accreditation.dashboard', ['hco' => $hco]);
    }
}
