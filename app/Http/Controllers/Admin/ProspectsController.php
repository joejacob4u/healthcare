<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProspectUser;

class ProspectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        $prospect_users = ProspectUser::get();
        return view('admin.healthsystem.prospects.index', ['prospect_users' => $prospect_users]);
    }

    public function details($id)
    {
        $prospect_user = ProspectUser::find($id);
        return view('admin.healthsystem.prospects.details', ['prospect_user' => $prospect_user]);
    }
}
