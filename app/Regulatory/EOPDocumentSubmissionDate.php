<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Carbon\Carbon;

class EOPDocumentSubmissionDate extends Model
{
    protected $table = 'eop_document_submission_dates';

    protected $guarded = ['id'];

    protected $dates = ['submission_date'];


    /**
     * eop - fetches eop of submission date
     *
     * @return eloquent collection
     */

    public function eop()
    {
        return $this->belongsTo('App\Regulatory\EOP', 'eop_id');
    }

    /**
     * building - fetches building for submission date
     *
     * @return eloquent collection
     */

     
    public function building()
    {
        return $this->belongsTo('App\Regulatory\Building', 'building_id');
    }

    /**
     * fetches all documents for given submission date
     *
     * @return eloquent collection
     */

    public function documents()
    {
        return $this->hasMany('App\Regulatory\EOPDocument', 'eop_document_submission_date_id');
    }



    /**
     * getTolerantUploadDates
     *
     * @return array
     */

    public function getTolerantUploadDates()
    {
        $date = new Carbon($this->submission_date);

        switch ($this->eop->frequency) {
          case 'daily':
            $start = $this->submission_date;
            $end = $this->submission_date;
            break;
  
          case 'weekly':
            $start = Carbon::parse($this->submission_date)->startOfWeek()->toDateString();
            $end = Carbon::parse($this->submission_date)->endOfWeek()->toDateString();
            break;
  
          case 'monthly':
            $start = Carbon::parse($this->submission_date)->startOfMonth()->toDateString();
            $end = Carbon::parse($this->submission_date)->endOfMonth()->toDateString();
            break;
  
          case 'quarterly':
            $start  = Carbon::parse($this->submission_date)->subDays(10)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(10)->toDateString();
            break;

          case 'annually':
            $start  = Carbon::parse($this->submission_date)->subDays(30)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(30)->toDateString();
            break;
  
          case 'two-years':
            $start  = Carbon::parse($this->submission_date)->subDays(30)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(30)->toDateString();
            break;
  
          case 'three-years':
            $start  = Carbon::parse($this->submission_date)->subDays(30)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(30)->toDateString();
            break;
  
          case 'four-years':
            $start  = Carbon::parse($this->submission_date)->subDays(30)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(30)->toDateString();
            break;
  
          case 'five-years':
            $start  = Carbon::parse($this->submission_date)->subDays(30)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(30)->toDateString();
            break;
  
          case 'six-years':
            $start  = Carbon::parse($this->submission_date)->subDays(30)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(30)->toDateString();
            break;

          case 'semi-annually':
            $start  = Carbon::parse($this->submission_date)->subDays(20)->toDateString();
            $end = Carbon::parse($this->submission_date)->addDays(20)->toDateString();
            break;
  
          case 'as-needed':
            return [];
            break;
  
          case 'per-policy':
            return [];
            break;
        }

        return ['start' => $start, 'end' => $end];
    }
}
