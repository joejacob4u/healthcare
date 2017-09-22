<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrequalifyContractor;
use Auth;
use App\User;

class SystemProspectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('system_admin');
    }

    public function index()
    {
        $users = User::where('status','pending')->get();
        $contract_users = PrequalifyContractor::where('healthsystem_id',Auth::guard('web')->user()->healthSystems->first()->id)->where('status','pending')->get();
        return view('prospects.index',['users' => $users,'contract_users' => $contract_users]);
    }

    public function download($user_id)
    {
        $public_dir = public_path().'/uploads';
        $zipFileName = $user_id.'_'.strtotime("now").'.zip';

        $files = Storage::disk('s3')->files('prequalify/user_files/'.Auth::guard('web')->user()->id.'/'.$user_id);
        $zip = new ZipArchive;

        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            
            foreach($files as $file)
            {
                $zip->addFile(Storage::disk('s3')->url($file),$file);        
            }

            $zip->close();
        }

        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );

        $filetopath = $public_dir.'/'.$zipFileName;

        if(file_exists($filetopath)){
            return response()->download($filetopath,$zipFileName,$headers);
        }
    }
}
