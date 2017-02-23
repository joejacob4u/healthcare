<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccrEOP;
use App\AccrRequirement;

class AdminAccreditationEOPController extends Controller
{
    public function index($accreditation_id)
    {
       $accr_requirement = AccrRequirement::find($accreditation_id);
       return view('admin.accreditation.eop.index',['accr_requirement' => $accr_requirement]);
    }

    public function viewAddIndex($accreditation_id)
    {
      $accr_requirement = AccrRequirement::find($accreditation_id);
      $eops = AccrEOP::pluck('elements_of_performance','id');
      return view('admin.accreditation.eop.add',['accr_requirement' => $accr_requirement,'eops' => $eops]);
    }

    public function create($accreditation_id,Request $request)
    {
        $this->validate($request,[
          'elements_of_performance' => 'required',
          'documentation' => 'required',
          'frequency' => 'required',
          'risk' => 'required',
          'risk_assessment' => 'required'
        ]);

        $accr_requirement = AccrRequirement::find($accreditation_id);

        $accr_eop = AccrEOP::create($request->all());

        if($accr_requirement->eops()->save($accr_eop))
        {
            if(isset($request->references))
            {
              foreach($request->references as $reference)
              {
                $references_eop = AccrEOP::find($reference);
                $accr_eop->referenceEops()->save($references_eop);
              }
            }

           return redirect('accreditation/eop/'.$accreditation_id)->with('success','A new EOP has been added!');
        }


        $eop = AccrEOP::find($accreditation_id);


    }
}
