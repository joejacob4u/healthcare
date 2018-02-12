<?php

namespace App\Regulatory;

use Illuminate\Database\Eloquent\Model;
use DB;

class EOP extends Model
{
    protected $table = 'eop';
    protected $fillable = ['name','standard_label_id','documentation','frequency','risk','risk_assessment','text','occupancy_type'];

    public function standardLabel()
    {
      return $this->belongsTo('App\Regulatory\StandardLabel','standard_label_id','id');
    }

    public function subCOPs()
    {
      return $this->belongsToMany('App\Regulatory\SubCOP','eop_sub-cop','eop_id','sub_cop_id');
    }

    public function getLastDocumentUpload($building_id)
    {
      return DB::table('eop_documentation')->select('eop_documentation.submission_date','users.name')
              ->where('building_id', $building_id)
              ->leftJoin('users', 'users.id', '=', 'eop_documentation.user_id')
              ->where('accreditation_id',session('accreditation_id'))
              ->where('eop_id',$this->id)->orderBy('submission_date', 'desc')
              ->first();
    }

    public function getNextDocumentUploadDate($building_id)
    {
      
      $submission_date = DB::table('eop_documentation')->select('eop_documentation.submission_date')
                        ->where('building_id', $building_id)
                        ->where('accreditation_id',session('accreditation_id'))
                        ->where('eop_id',$this->id)->orderBy('submission_date', 'desc')
                        ->first();

      if(!$submission_date)
      {
        return 'Next Upload Date will be calculated after your first upload.';
      }


      switch($this->frequency)
      {
        case 'daily':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('tomorrow',strtotime($submission_date->submission_date)));
          break;

        case 'weekly':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+1 week',strtotime($submission_date->submission_date)));
          break;

        case 'monthly':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+1 month',strtotime($submission_date->submission_date)));
          break;

        case 'quarterly':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+3 month',strtotime($submission_date->submission_date)));
          break;

        case 'annually':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+1 year',strtotime($submission_date->submission_date)));
          break;

        case 'two-years':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+2 year',strtotime($submission_date->submission_date)));
          break;

        case 'three-years':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+3 year',strtotime($submission_date->submission_date)));
          break;

        case 'four-years':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+4 year',strtotime($submission_date->submission_date)));
          break;

        case 'five-years':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+5 year',strtotime($submission_date->submission_date)));
          break;

        case 'six-years':
          $next_date_string = 'Next Upload Date : '.date('F j, Y',strtotime('+6 year',strtotime($submission_date->submission_date)));
          break;

        case 'semi-annually':
          $next_date_string = 'Next Upload Date : Semi - Annually';
          break;

        case 'as-needed':
          $next_date_string = 'Next Upload Date : As Needed';
          break;

        case 'per-policy':
          $next_date_string = 'Next Upload Date : Per Policy';
          break;
      }

      return $next_date_string;

    }


}
