<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\PrequalifyConfig;
use App\Regulatory\HealthSystem;
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
        $prequalify_configs = HealthSystem::find(Auth::guard('web')->user()->healthSystems->first()->id)->prequalifyConfigs;
        return view('prequalify.index',['prequalify_configs' => $prequalify_configs]);
    }

    public function create()
    {
        return view('prequalify.add');
    }

    public function store(Request $request)
    {
        $files = json_decode($_REQUEST['files']);
        $requirements = json_decode($_REQUEST['requirements']);
        $emails = json_decode($_REQUEST['emails']);
        $welcome_files = json_decode($_REQUEST['welcome_files']);

        PrequalifyConfig::where('healthsystem_id',Auth::guard('web')->user()->healthSystems->first()->id)->delete();


        foreach($files as $key => $file)
        {
            $aFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['healthsystem_id'] = Auth::guard('web')->user()->healthSystems->first()->id;
            (strpos($key, 'input_type') !== false) ? $aFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['input_type'] = $file : '';
            (strpos($key, 'action_type') !== false) ? $aFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['action_type'] = $file : '';
            (strpos($key, 'file_path') !== false) ? $aFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['value'] =  $file : '';
            (strpos($key, 'file_acknowledged') !== false) ? $aFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['is_required'] = $file : '';
            (strpos($key, 'file_description') !== false) ? $aFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['description'] = $file : '';
        }

        foreach($aFiles as $file)
        {
            PrequalifyConfig::create($file);
        }

        foreach($welcome_files as $key => $file)
        {
            $aWelcomeFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['healthsystem_id'] = Auth::guard('web')->user()->healthSystems->first()->id;
            (strpos($key, 'input_type') !== false) ? $aWelcomeFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['input_type'] = $file : '';
            (strpos($key, 'action_type') !== false) ? $aWelcomeFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['action_type'] = $file : '';
            (strpos($key, 'file_path') !== false) ? $aWelcomeFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['value'] =  $file : '';
            $aWelcomeFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['is_required'] = 0;
            $aWelcomeFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['description'] = 'Welcome abroad file';
        }

        foreach($aWelcomeFiles as $file)
        {
            PrequalifyConfig::create($file);
        }


        foreach($requirements as $key => $requirement)
        {
            $aRequirements[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['healthsystem_id'] = Auth::guard('web')->user()->healthSystems->first()->id;
            (strpos($key, 'input_type') !== false) ? $aRequirements[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['input_type'] = $requirement : '';
            (strpos($key, 'action_type') !== false) ? $aRequirements[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['action_type'] = $requirement : '';
            (strpos($key, 'requirement_path') !== false) ? $aRequirements[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['value'] =  $requirement : '';
            (strpos($key, 'requirement_acknowledged') !== false) ? $aRequirements[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['is_required'] = $requirement : '';
            (strpos($key, 'requirement_description') !== false) ? $aRequirements[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['description'] = $requirement : '';
        }

        foreach($aRequirements as $requirement)
        {
            PrequalifyConfig::create($requirement);
        }

        foreach($emails as $key => $email)
        {
            $aEmails[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['healthsystem_id'] = Auth::guard('web')->user()->healthSystems->first()->id;
            (strpos($key, 'input_type') !== false) ? $aEmails[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['input_type'] = $email : '';
            (strpos($key, 'action_type') !== false) ? $aEmails[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['action_type'] = $email : '';
            (strpos($key, 'email_address_value_') !== false) ? $aEmails[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['value'] =  $email : '';
            $aEmails[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['is_required'] = 1;
            $aEmails[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['description'] = 'delivery email';
        }

        foreach($aEmails as $email)
        {
            PrequalifyConfig::create($email);
        }


        $aAcknowledgement = [
            'healthsystem_id' => Auth::guard('web')->user()->healthSystems->first()->id,
            'input_type' => 'textarea',
            'action_type' => 'output',
            'value' => $request->acknowledgement_statement,
            'is_required' => $request->acknowledgement_statement_acknowledge,
            'description' => 'Acknowledgement'
        ];


        PrequalifyConfig::create($aAcknowledgement);

        $aWelcomeMessage = [
            'healthsystem_id' => Auth::guard('web')->user()->healthSystems->first()->id,
            'input_type' => 'textarea',
            'action_type' => 'email',
            'value' => $request->welcome_message,
            'is_required' => 0,
            'description' => 'Welcome email message'
        ];

        PrequalifyConfig::create($aWelcomeMessage);

        echo 'true';


    }

    public function upload(Request $request)
    {
        $path = $request->file('uploadfile')->store('prequalify/config','s3');
        return $path;
    }
}
