<?php

namespace App\Http\Controllers;

use App\Regulatory\HealthSystem;
use App\PrequalifyConfig;
use App\Contractor;
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
        $contractor = Contractor::find(Auth::guard('contractor')->user()->id);
        
        // $applications = Contractor::whereHas('healthSystems',function($query){ $query
        //     ->where('contractor_id',Auth::guard('contractor')->user()->id);
        // })->get();
            
        return view('prequalify.apply.index',['healthsystems' => $healthsystems,'contractor' => $contractor]);
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
        $path = $request->file('uploadfile')->store('prequalify/user_files/'.Auth::guard('contractor')->user()->id.'/'.$request->healthsystem_id,'s3');
        return $path;
    }

    public function apply(Request $request)
    {
        $philanthropy_emails = PrequalifyConfig::where('healthsystem_id',$request->healthsystem_id)->where('input_type','email')->where('action_type','system')->get();
        $files = Storage::disk('s3')->files('prequalify/user_files/'.Auth::guard('contractor')->user()->id.'/'.$request->healthsystem_id);
        $welcome_files = PrequalifyConfig::where('healthsystem_id',$request->healthsystem_id)->where('input_type','file')->where('action_type','email')->get();
        $welcome_message = PrequalifyConfig::where('healthsystem_id',$request->healthsystem_id)->where('input_type','textarea')->where('action_type','email')->get();

        $healthsystem = HealthSystem::find($request->healthsystem_id);

        foreach($philanthropy_emails as $emails)
        {
            $data = [
                    'healthsystem' => $healthsystem->healthcare_system,
                    'user' => Auth::guard('contractor')->user(),
                    'files' => $files,
            ];

            Mail::send('email.philanthropy', $data, function($message) use ($emails) 
            {
                $message->from('donotreply@healthcare365.com', 'HealthCare Compliance 365');
            
                $message->to($emails->value);
                $message->subject('New prequalify application');
                                
            });
    
        }

        $welcome_email_address = Auth::guard('contractor')->user()->email;

        $data = [
            'content' => $welcome_message[0]['value'],
            'welcome_files' => $welcome_files
        ];

        Mail::send('email.welcome',$data, function($message) use ($welcome_email_address) 
        {
            $message->from('donotreply@healthcare365.com', 'HealthCare Compliance 365');
        
            $message->to($welcome_email_address);
            $message->subject('Welcome to HealthCare Compliance 365');
                        
        });

        $contractor = Contractor::find(Auth::guard('contractor')->user()->id);

        if($contractor->healthSystems()->syncWithoutDetaching([$request->healthsystem_id => ['is_active' => 0]]))
        {
            return 'true';
        }


        


    }

}
