<?php

namespace App\Equipment;

use DateTime;
use DateInterval;
use DatePeriod;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'equipment_inventory';

    protected $guarded = ['id'];

    public function baselineDate()
    {
        return $this->belongsTo('App\Equipment\BaselineDate', 'baseline_date_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Regulatory\Room', 'room_id');
    }

    public function equipment()
    {
        return $this->belongsTo('App\Equipment\Equipment', 'equipment_id');
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

    public function calculateEquipmentServiceAge()
    {
        $end = time();
        $start = new DateTime($this->installation_date);
        $end   = new DateTime("@$end");
        $diff  = $start->diff($end);
        return ($diff->format('%y') * 12 + $diff->format('%m') > 0) ? $diff->format('%y') * 12 + $diff->format('%m') : 1;
    }

    public function USLScore()
    {
        $equipment_age_in_months = $this->calculateEquipmentServiceAge();

        //get service life for category

        $service_life_in_months = ($this->baselineDate->equipment->assetCategory->service_life > 0) ? $this->baselineDate->equipment->assetCategory->service_life : 1;

        if ($equipment_age_in_months <= 12) {
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

        $score += ($this->baselineDate->equipment->assetCategory->physicalRisk->score + $this->baselineDate->equipment->assetCategory->utilityFunction->score);

        //now lets do requirement frequency and redundancy

        $score += ($this->baselineDate->equipment->maintenanceRequirement->score + $this->missionCriticality->score + $this->incidentHistory->score);

        //add usl score too

        $score += $this->USLScore();

        return number_format($score/3.2, 2);
    }

    public function EMNumberScore()
    {
        // EM Number Score = Function + Risk + Maint Req

        $score = 0;

        $score += ($this->baselineDate->equipment->maintenanceRequirement->score + $this->baselineDate->equipment->assetCategory->physicalRisk->score + $this->baselineDate->equipment->assetCategory->utilityFunction->score);

        return $score;
    }

    public function EMRatingScore()
    {
        // mission critical rating + (2×risk) + (2×maintenance)

        $score = (($this->missionCriticality->score + (2 * $this->baselineDate->equipment->assetCategory->physicalRisk->score) + (2 * $this->baselineDate->equipment->maintenanceRequirement->score)));

        return number_format($score, 2);
    }

    public function AdjustedEMRScore()
    {
        // (Mission Criticality x Utilization % + 2 x Utilization x Maintenance Requirement + 200 x Physical Risk - 30) / 10

        $score = ($this->missionCriticality->score * ($this->utilization / 100) + 2 * ($this->utilization / 100) * $this->baselineDate->equipment->maintenanceRequirement->score + 200 * $this->baselineDate->equipment->assetCategory->physicalRisk->score - 30) / 10;

        return $score;
    }

    public function FCINumber()
    {
        $equipment_age_in_months = $this->calculateEquipmentServiceAge();

        //get service life for category

        $service_life_in_months = ($this->baselineDate->equipment->assetCategory->service_life > 0) ? $this->baselineDate->equipment->assetCategory->service_life : 1;

        if ($service_life_in_months <= 12) {
            return 0.01;
        }

        $usl_percentage = number_format(($equipment_age_in_months / $service_life_in_months) * 100, 0);

        return number_format($usl_percentage * .003, 3);
    }

    public function equipmentRiskScore()
    {
        $score = 0;

        $inventory_age_in_months = $this->calculateEquipmentServiceAge();

        if ($inventory_age_in_months > 60) {
            $score += 1;
        }

        if (!$this->baselineDate->equipment->meet_current_oem_specifications) {
            $score += 1;
        }
        if (!$this->baselineDate->equipment->is_manufacturer_supported) {
            $score += 1;
        }
        if ($this->baselineDate->equipment->impact_of_device_failure == 'minor') {
            $score += 1;
        }
        if ($this->baselineDate->equipment->impact_of_device_failure == 'major') {
            $score += 2;
        }
        if (!$this->baselineDate->equipment->is_maintenance_supported) {
            $score += 1;
        }

        return $score;
    }
}
