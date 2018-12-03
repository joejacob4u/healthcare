<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateInterval;
use DatePeriod;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $guarded = ['id'];

    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Regulatory\Room', 'room_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Equipment\Category', 'equipment_category_id');
    }



    public function assetCategory()
    {
        return $this->belongsTo('App\Equipment\AssetCategory', 'equipment_asset_category_id');
    }

    public function maintenanceRequirement()
    {
        return $this->belongsTo('App\Equipment\MaintenanceRequirement', 'equipment_maintenance_requirement_id');
    }

    public function redundancy()
    {
        return $this->belongsTo('App\Equipment\Redundancy', 'maintenance_redundancy_id');
    }

    public function missionCriticality()
    {
        return $this->belongsTo('App\Biomed\MissionCriticality', 'biomed_mission_criticality_id');
    }

    public function incidentHistory()
    {
        return $this->belongsTo('App\Equipment\IncidentHistory', 'equipment_incident_history_id');
    }

    public function workOrders()
    {
        return $this->hasMany('App\Equipment\WorkOrder', 'equipment_id');
    }

    public function lastWorkOrderStatus()
    {
        $status = 1;

        foreach ($this->workOrders as $work_order) {
            foreach ($work_order->workOrderStatuses() as $work_order_status) {
                if ($work_order_status->id > $status) {
                    $status = $work_order_status->id;
                }
            }
        }

        return WorkOrderStatus::find($status)->name;
    }
    
    public function calculateEquipmentServiceAge()
    {
        $end = time();
        $start = new DateTime($this->manufacturer_date);
        $end   = new DateTime("@$end");
        $diff  = $start->diff($end);
        return ($diff->format('%y') * 12 + $diff->format('%m') > 0) ? $diff->format('%y') * 12 + $diff->format('%m') : 1;
    }

    public function USLScore()
    {
        $equipment_age_in_months = $this->calculateEquipmentServiceAge();

        //get service life for category

        $service_life_in_months = ($this->assetCategory->service_life > 0) ? $this->assetCategory->service_life : 1;

        if ($service_life_in_months <= 12) {
            return 1;
        }


        //calculate percentage number

        $percentage = 100 - number_format(($equipment_age_in_months / $service_life_in_months) * 100, 0);

 
        //lets figure out what category they are in

        if ($percentage <= 100 and $percentage >= 76) {
            $score = 2;
        } elseif ($percentage <= 75 and $percentage >= 51) {
            $score = 3;
        } elseif ($percentage <= 50 and $percentage >= 25) {
            $score = 4;
        } elseif ($percentage <= 24 and $percentage >= 10) {
            $score = 5;
        } elseif ($percentage <= 9) {
            $score = 6;
        }

        return $score;
    }

    public function missionCriticalityRatingScore()
    {
        // (Function score + Mission Criticality Score + USL Condition Score + Risk Score + Maint Req Score + Recals and Alerts Score)/3.2

        $score = 0;
        
        //calculate score for asset category first

        $score += ($this->assetCategory->physicalRisk->score + $this->assetCategory->utilityFunction->score);

        //now lets do requirement frequency and redundancy

        $score += ($this->maintenanceRequirement->score + $this->missionCriticality->score + $this->incidentHistory->score);

        //add usl score too

        $score += $this->USLScore();

        return number_format($score/3.2, 2);
    }

    public function EMNumberScore()
    {
        // EM Number Score = Function + Risk + Maint Req

        $score = 0;

        $score += ($this->maintenanceRequirement->score + $this->assetCategory->physicalRisk->score + $this->assetCategory->utilityFunction->score);

        return $score;
    }

    public function EMRatingScore()
    {
        // mission critical rating + (2×risk) + (2×maintenance)

        $score = (($this->missionCriticality->score + (2 * $this->assetCategory->physicalRisk->score) + (2 * $this->maintenanceRequirement->score)));

        return number_format($score, 2);
    }

    public function AdjustedEMRScore()
    {
        // (Mission Criticality x Utilization % + 2 x Utilization x Maintenance Requirement + 200 x Physical Risk - 30) / 10

        $score = ($this->missionCriticality->score * ($this->utilization / 100) + 2 * ($this->utilization / 100) * $this->maintenanceRequirement->score + 200 * $this->assetCategory->physicalRisk->score - 30) / 10;

        return number_format($score, 2);
    }

    public function FCINumber()
    {
        $equipment_age_in_months = $this->calculateEquipmentServiceAge();

        //get service life for category

        $service_life_in_months = ($this->assetCategory->service_life > 0) ? $this->assetCategory->service_life : 1;

        if ($service_life_in_months <= 12) {
            return 0.01;
        }

        $usl_percentage = number_format(($equipment_age_in_months / $service_life_in_months) * 100, 0);

        return number_format($usl_percentage * .003, 3);
    }



    public function calculateEquipmentWorkOrderDates()
    {
        switch ($this->frequency) {
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

            case 'as-needed':
                return [];
                break;

            case 'per-policy':
                return [];
                break;
        }

        $from = new DateTime($this->baseline_date);

        $to = new DateTime(date('Y-m-d'));

        $to->modify($future_date_interval);

        $interval = new DateInterval($interval);
        
        $periods = new DatePeriod($from, $interval, $to);
        
        $dates = [];

        foreach ($periods as $period) {
            $dates[] = $period->format('Y-m-d');
        }

        //fetch existing dates

        $existing_dates = [];

        foreach ($this->workOrders as $work_order) {
            $existing_dates[] = $work_order->work_order_date;
        }

        return array_diff($dates, $existing_dates);
    }
}
