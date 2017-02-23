<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\AccrRequirement;

class AdminAccreditationController extends Controller
{
    public function index()
    {
      $requirements = AccrRequirement::get();
      return view('admin.accreditation.index',['requirements' => $requirements]);
    }

    public function addView()
    {
      $departments = Department::pluck('name','id');

      return view('admin.accreditation.add',[
        'departments' => $departments
      ]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
          'label' => 'required|max:255',
          'text' => 'required',
          'department_id' => 'required'
        ]);

        if(AccrRequirement::create($request->all()))
        {
          return redirect('admin/accreditation');
        }


    }
}
