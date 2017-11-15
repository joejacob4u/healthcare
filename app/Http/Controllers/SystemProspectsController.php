<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Role;
use App\Contractor;

class SystemProspectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('system_admin');
    }

    public function index()
    {
        $users = User::where('healthsystem_id',0)->where('role_id',12)->get();
        $contract_users = Contractor::whereHas('healthSystems', function ($query) { $query->where('healthsystem_id',Auth::guard('web')->user()->healthsystem_id); })->get();
        return view('prospects.index',['users' => $users,'contract_users' => $contract_users]);
    }

    public function getUserRole(Request $request)
    {
        $roles = Role::whereNotIn('id',['1','2','3'])->get();
        $user = User::find($request->user_id);
        return response()->json(['roles' => $roles,'user_role' => $user->role_id]);
    }

    public function setUserRole(Request $request)
    {
        $user = User::find($request->user_id);

        if($user->update(['role_id' => $request->role_id]))
        {
            return response()->json(['status' => 'success','role' => $user->role->name]);
        }
    }

    public function details(Request $request)
    {
        $files = Storage::disk('s3')->files('prequalify/user_files/'.$request->user_id.'/'.Auth::guard('web')->user()->healthsystem_id);
        return $files;

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
