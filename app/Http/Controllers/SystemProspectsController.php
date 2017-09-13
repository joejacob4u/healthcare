<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrequalifyUser;
use Auth;

class SystemProspectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $prequalify_users = PrequalifyUser::where('healthsystem_id',Auth::guard('web')->user()->healthSystems->first()->id)->get();
        return view('prospects.index',['prequalify_users' => $prequalify_users]);
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
