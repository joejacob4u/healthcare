<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\PrequalifyConfig;
use App\HealthSystem;
use Storage;

class PrequalifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $prequalify_configs = HealthSystem::find(Auth::guard('web')->user()->healthsystem_id)->prequalifyConfigs;
    }

    public function create()
    {
        return view('prequalify.add');
    }

    public function store(Request $request)
    {
        dd($request);
    }

    public function upload(Request $request)
    {
        $path = $request->file('uploadfile')->store('prequalify','s3');
        return Storage::disk('s3')->url($path);
    }
}
