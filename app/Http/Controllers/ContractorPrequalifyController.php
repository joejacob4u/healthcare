<?php

namespace App\Http\Controllers;

use App\Regulatory\HealthSystem;
use App\PrequalifyConfig;
use App\PrequalifyUser;
use Illuminate\Http\Request;
use Storage;
use Mail;
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
        $applications = PrequalifyUser::where('user_id',Auth::guard('web')->user()->id)->get();
        return view('prequalify.apply.index',['healthsystems' => $healthsystems,'applications' => $applications]);
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
        $philanthropy_emails = PrequalifyConfig::where('healthsystem_id',$request->healthsystem_id)->where('input_type','email')->where('action_type','system')->get();
        $files = Storage::disk('s3')->files('prequalify/user_files/'.Auth::guard('web')->user()->id);
        $welcome_files = PrequalifyConfig::where('healthsystem_id',$request->healthsystem_id)->where('input_type','file')->where('action_type','email')->get();
        $welcome_message = PrequalifyConfig::where('healthsystem_id',$request->healthsystem_id)->where('input_type','textarea')->where('action_type','email')->get();

        $healthsystem = HealthSystem::find($request->healthsystem_id);

        foreach($philanthropy_emails as $emails)
        {
            Mail::send('email.philanthropy', ['healthsystem' => $healthsystem->healthcare_system,'user' => Auth::guard('web')->user()->email], function($message) use ($files,$emails) 
            {
                $message->from('donotreply@healthcare365.com', 'HealthCare Compliance 365');
            
                $message->to($emails->value);
                $message->subject('New prequalify application');
                
                foreach($files as $file)
                {
                    $message->attach(Storage::disk('s3')->url($file));
                }
                
            });
    
        }

        $welcome_email_address = Auth::guard('web')->user()->email;

        Mail::send('email.welcome', ['content' => $welcome_message[0]['value']], function($message) use ($welcome_files,$welcome_email_address) 
        {
            $message->from('donotreply@healthcare365.com', 'HealthCare Compliance 365');
        
            $message->to($welcome_email_address);
            $message->subject('Welcome to HealthCare Compliance 365');
            
            foreach($welcome_files as $file)
            {
                $message->attach(Storage::disk('s3')->url($file->value));
            }
            
        });

        PrequalifyUser::create(['user_id' => Auth::guard('web')->user()->id,'healthsystem_id' => $request->healthsystem_id,'status' => 'pending']);

        return 'true';


    }

}
