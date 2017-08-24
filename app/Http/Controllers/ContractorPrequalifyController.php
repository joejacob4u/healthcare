<?php

namespace App\Http\Controllers;

use App\Regulatory\HealthSystem;
use App\PrequalifyConfig;
use Illuminate\Http\Request;
use Storage;
use Auth;

class ContractorPrequalifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('prospect_contractor');
    }

    public function index()
    {
        $healthsystems = HealthSystem::get();
        return view('prequalify.apply.index',['healthsystems' => $healthsystems]);
    }

    public function create($id)
    {
        $prequalify_form = PrequalifyConfig::where('healthsystem_id',$id)->get();
        return view('prequalify.apply.apply',['prequalify_form' => $prequalify_form,'healthsystem_id' => $id]);
    }

    public function download($id)
    {
        $path = PrequalifyConfig::find($id)->value;
        $fs = Storage::disk('s3')->getDriver();
        $stream = $fs->readStream($path);
        return \Response::stream(function() use($stream) {
            fpassthru($stream);
        }, 200, [
            "Content-Type" => $fs->getMimetype($path),
            "Content-Length" => $fs->getSize($path),
            "Content-disposition" => "attachment; filename=\"" .basename($path) . "\"",
            ]);
    }

    public function upload(Request $request)
    {
        $path = $request->file('uploadfile')->store('prequalify/user_files/'.Auth::guard('web')->user()->id,'s3');
        return $path;
    }

    public function apply(Request $request)
    {
        
    }

}
