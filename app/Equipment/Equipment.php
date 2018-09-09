<?php

namespace App\Equipment;

use Illuminate\Database\Eloquent\Model;
use DateTime;

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

        if ($percentage < 100 and $percentage >= 76) {
            $score = 2;
        } elseif ($percentage < 75 and $percentage >= 51) {
            $score = 3;
        } elseif ($percentage < 50 and $percentage >= 25) {
            $score = 4;
        } elseif ($percentage < 24 and $percentage >= 10) {
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
        // ((Mission Critical + (2x Risk) + (2x Maintenance)+1))/2

        $score = (($this->missionCriticality->score + (2 * $this->assetCategory->physicalRisk->score) + (2 * $this->maintenanceRequirement->score) + 1))/2;

        return number_format($score, 2);
    }

    public function AdjustedEMRScore()
    {
        // ((((Mission Critical + (2x Maintenance)) x (Utilization/100) + (2x Risk)) x 0.1) - 0.01

        $score = $this->missionCriticality->score + (2 * $this->maintenanceRequirement->score);

        $score *= ($this->utilization / 100) + (2 * $this->assetCategory->physicalRisk->score);

        $score *= 0.1;

        $score -= 0.01;

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

        $usl_percentage = 100 - number_format(($equipment_age_in_months / $service_life_in_months) * 100, 0);

        return number_format($usl_percentage * .0033, 3);
    }
}
