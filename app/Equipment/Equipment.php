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

    public function USLScore()
    {
        //calculate difference between manufacture date and current date

        $end = time();
        $start = new DateTime($this->manufacturer_date);
        $end   = new DateTime("@$end");
        $diff  = $start->diff($end);
        $equipment_age_in_months = ($diff->format('%y') * 12 + $diff->format('%m') > 0) ? $diff->format('%y') * 12 + $diff->format('%m') : 1;

        //get service life for category

        $service_life_in_months = ($this->assetCategory->service_life > 0) ? $this->assetCategory->service_life : 1;

        //calculate percentage number

        $percentage = round(($equipment_age_in_months / $service_life_in_months) * 100, 0);

 
        //lets figure out what category they are in

        if ($percentage >= 90) {
            $score = 1;
        } elseif ($percentage < 90 and $percentage >= 75) {
            $score = 2;
        } elseif ($percentage < 75 and $percentage >= 50) {
            $score = 3;
        } elseif ($percentage < 50 and $percentage >= 25) {
            $score = 3;
        } elseif ($percentage < 25 and $percentage >= 10) {
            $score = 4;
        } elseif ($percentage <= 10) {
            $score = 5;
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

        $score += ($this->maintenanceRequirement->score + $this->redundancy->score + $this->missionCriticality->score + $this->incidentHistory->score);

        //add usl score too

        $score += $this->USLScore();

        return round($score/3.2, 2);
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
        // EM Rating Score - Mission Critical Rating + (2xRisk) + (2xMaintenance)

        $score = 0;

        $score += $this->missionCriticality->score + (2 *$this->maintenanceRequirement->score) + (2 * $this->assetCategory->physicalRisk->score);

        return $score;
    }

    public function AdjustedEMRScore()
    {
        // Adjusted EMR = (Mission Critical Rating + (2xMaintenance))x Utilization + (2xRisk)

        $score = 0;

        $score += ($this->missionCriticality->score + (2 *$this->maintenanceRequirement->score)) * $this->assetCategory->utilityFunction->score + (2 * $this->assetCategory->physicalRisk->score);

        return $score;
    }
}
