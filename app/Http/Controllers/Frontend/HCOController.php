<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;
use App\Regulatory\HealthSystem;
use App\Regulatory\Accreditation;
use Auth;

class HCOController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $health_system = HealthSystem::find(Auth::guard('system_user')->user()->healthsystem_id);
        $hcos = $health_system->HCOs;
        return view('frontend.healthsystem.hco.index', ['hcos' => $hcos,'health_system' => $health_system]);
    }
}
