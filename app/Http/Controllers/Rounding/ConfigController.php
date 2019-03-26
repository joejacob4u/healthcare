<?php

namespace App\Http\Controllers\Rounding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rounding\Config;
use App\Regulatory\BuildingDepartment;
use App\Rounding\ChecklistType;
use App\User;
use App\Rounding\Rounding;
use DateTime;
use DateInterval;
use DatePeriod;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $configs = Config::where('building_id', session('building_id'))->paginate('15');
        return view('rounding.config.index', ['configs' => $configs]);
    }

    public function create()
    {
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id');
        $checklist_types = ChecklistType::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('rounding.config.add', ['departments' => $departments, 'checklist_types' => $checklist_types,'users' => $users]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'building_department_id' => 'required',
            'rounding_checklist_type_id' => 'required',
            'frequency' => 'required',
            'baseline_date' => 'required',
            'user_id' => 'required'
        ]);

        if ($config = Config::create($request->all())) {
            $this->create_roundings($config);
            return redirect('rounding/config')->with('success', 'Config created');
        }
    }

    public function edit(Config $config)
    {
        $departments = BuildingDepartment::where('building_id', session('building_id'))->pluck('name', 'id');
        $checklist_types = ChecklistType::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('rounding.config.edit', ['config' => $config,'departments' => $departments, 'checklist_types' => $checklist_types]);
    }

    public function update(Request $request, Config $config)
    {
        $this->validate($request, [
            'building_department_id' => 'required',
            'rounding_checklist_type_id' => 'required',
            'frequency' => 'required',
            'baseline_date' => 'required',
            'user_id' => 'required'
        ]);

        if ($config->update($request->all())) {
            return redirect('rounding/config')->with('success', 'Config updated');
        }
    }

    public function destroy(Request $request)
    {
        if (Config::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }
    }

    private function create_roundings(Config $config)
    {
        switch ($config->frequency) {
            
            case 'daily':
              $interval = 'P1D';
              $future_date_interval = '+1 day';
              break;
    
            case 'weekly':
              $interval = 'P1W';
              $future_date_interval = '+1 week';
              break;
    
            case 'monthly':
              $interval = 'P1M';
              $future_date_interval = '+1 month';
              break;
    
            case 'quarterly':
                $interval = 'P3M';
                $future_date_interval = '+3 month';
                break;
    
            case 'annually':
                $interval = 'P1Y';
                $future_date_interval = '+1 year';
                break;
    
            case 'two-years':
                $interval = 'P2Y';
                $future_date_interval = '+2 year';
                break;
    
            case 'three-years':
                $interval = 'P3Y';
                $future_date_interval = '+3 year';
                break;
    
            case 'four-years':
                $interval = 'P4Y';
                $future_date_interval = '+4 year';
                break;
    
            case 'five-years':
                $interval = 'P5Y';
                $future_date_interval = '+5 year';
                break;
    
            case 'six-years':
                $interval = 'P6Y';
                $future_date_interval = '+6 year';
                break;
    
            case 'semi-annually':
                $interval = 'P6M';
                $future_date_interval = '+6 month';
                break;
    
            }
    
        $from = new DateTime($config->baseline_date);
        $to = new DateTime(date('Y-m-d'));
    
        $interval = new DateInterval($interval);
        $periods = new DatePeriod($from, $interval, $to);
        $dates = [];
    
        foreach ($periods as $period) {
            $dates[] = $period->format('Y-m-d');
        }

        foreach ($dates as $date) {
            Rounding::create([
                'rounding_config_id' => $config->id,
                'building_id' => $config->building_id,
                'date' => $date,
                'rounding_status_id' => 1
            ]);
        }
    }
}
