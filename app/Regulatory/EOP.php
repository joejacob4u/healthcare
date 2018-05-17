<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;
use App\Regulatory\EOPDocument;
use App\Regulatory\EOPDocumentBaselineDate;
use App\Regulatory\EOPDocumentSubmissionDate;

class EOP extends Model
{
    protected $table = 'eop';
    
    protected $fillable = ['name','standard_label_id','documentation','frequency','risk','risk_assessment','text','occupancy_type'];

    public function standardLabel()
    {
        return $this->belongsTo('App\Regulatory\StandardLabel', 'standard_label_id', 'id');
    }

    public function subCOPs()
    {
        return $this->belongsToMany('App\Regulatory\SubCOP', 'eop_sub-cop', 'eop_id', 'sub_cop_id');
    }

    public function getSubmissionDates()
    {
        return EOPDocumentSubmissionDate::where('building_id', session('building_id'))->where('accreditation_id', session('accreditation_id'))->where('eop_id', $this->id)->get();
    }

    public function getLastDocumentUpload($building_id)
    {
        return DB::table('eop_documents')->select('eop_documents.submission_date', 'users.name')
              ->where('building_id', $building_id)
              ->leftJoin('users', 'users.id', '=', 'eop_documents.user_id')
              ->where('accreditation_id', session('accreditation_id'))
              ->where('eop_id', $this->id)->orderBy('submission_date', 'desc')
              ->first();
    }

    public function documentBaseLineDate()
    {
        return $this->belongsToMany('App\Regulatory\Building', 'documentation_baseline_dates', 'eop_id', 'building_id')->withPivot('baseline_date');
    }

    public function getDocumentBaseLineDate($building_id)
    {
        return DB::table('documentation_baseline_dates')->where('building_id', $building_id)->where('eop_id', $this->id)->select('baseline_date', 'is_baseline_disabled', 'comment')->where('accreditation_id', session('accreditation_id'))->first();
    }

    public function getNextDocumentUploadDate()
    {
        if (!empty($this->getDocumentBaseLineDate(session('building_id'))->baseline_date)) {
            $document_dates = $this->calculateDocumentDates($this->getDocumentBaseLineDate(session('building_id'))->baseline_date, true);
            if (!empty(end($document_dates))) {
                return end($document_dates);
            } else {
                return 'cannot_find_date';
            }
        } else {
            return '';
        }
    }

    public function getFindingCount($status)
    {
        return DB::table('eop_findings')->where('eop_id', $this->id)->where('status', $status)->count();
    }

    public function calculateDocumentDates($baseline_date, $list_all = false)
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

        $from = new DateTime($baseline_date);
        $to = new DateTime(date('Y-m-d'));
        if ($list_all) {
            $to->modify($future_date_interval);
        }

        $interval = new DateInterval($interval);
        $periods = new DatePeriod($from, $interval, $to);
        $dates = [];

        foreach ($periods as $period) {
            $dates[] = $period->format('Y-m-d');
        }

        //get uploaded documents

        $documents = [];
        $document_dates = [];
        $documents = $this->getSubmissionDates()->toArray();
      
        if (!empty($documents)) {
            foreach ($documents as $document) {
                $document_dates[] = date('Y-m-d', strtotime($document['submission_date']));
            }
        }

        if ($list_all) {
            return $dates;
        } else {
            return array_diff($dates, $document_dates);
        }
    }
}
