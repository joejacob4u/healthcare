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
        $files = json_decode($_REQUEST['files']);
        $requirements = json_decode($_REQUEST['requirements']);

        foreach($files as $key => $file)
        {
            $aFiles[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['healthsystem_id'] = Auth::guard('web')->user()->healthsystem_id;
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

        foreach($requirements as $key => $requirement)
        {
            $aRequirements[filter_var($key, FILTER_SANITIZE_NUMBER_INT)]['healthsystem_id'] = Auth::guard('web')->user()->healthsystem_id;
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

        $aAcknowledgement = [
            'healthsystem_id' => Auth::guard('web')->user()->healthsystem_id,
            'input_type' => 'textarea',
            'action_type' => 'output',
            'value' => $request->acknowledgement_statement,
            'is_required' => $request->acknowledgement_statement_acknowledge,
            'description' => 'Acknowledgement'
        ];

        PrequalifyConfig::create($aAcknowledgement);

        return 'true';


    }

    public function upload(Request $request)
    {
        $path = $request->file('uploadfile')->store('prequalify','s3');
        return Storage::disk('s3')->url($path);
    }
}
