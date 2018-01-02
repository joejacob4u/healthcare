<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Workflow\AdministrativeLeader;

class AdministrativeLeaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $administrative_leaders = AdministrativeLeader::get();
        return view('workflow.administrative-leader.index',['administrative_leaders' => $administrative_leaders]);
    }

    public function create()
    {
        return view('workflow.administrative-leader.add');
    }


}
