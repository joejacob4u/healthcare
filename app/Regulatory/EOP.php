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

    }


}
