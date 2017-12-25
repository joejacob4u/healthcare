<?php

namespace App\Http\Controllers\Workflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Workflow\FinancialCategoryCode;

class FinancialCategoryCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }

    public function index()
    {
        $financial_catergory_codes = FinancialCategoryCode::get();
        return view('workflow.financial-category-code.index',['financial_catergory_codes' => $financial_catergory_codes]);
    }

    public function create()
    {
        return view('workflow.financial-category-code.add');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'category_group' => 'required',
            'category' => 'required',
            'category_number' => 'required'
        ]);

        if(FinancialCategoryCode::create($request->all()))
        {
            return redirect('workflows/financial-category-codes')->with('success','New Financial Category Code');
        }
    }

    public function edit($financial_catergory_code)
    {
        $financial_catergory_code = FinancialCategoryCode::find($financial_catergory_code);
        return view('workflow.financial-category-code.edit',['financial_catergory_code' => $financial_catergory_code]);
    }

    public function save(Request $request,$financial_catergory_code)
    {
        $this->validate($request,[
            'category_group' => 'required',
            'category' => 'required',
            'category_number' => 'required'
        ]);

        $financial_catergory_code = FinancialCategoryCode::find($financial_catergory_code);

        if($financial_catergory_code->update($request->all()))
        {
            return redirect('workflows/financial-category-codes')->with('success','Financial Category Code saved');
        }
    }

    public function delete(Request $request)
    {
        if(FinancialCategoryCode::destroy($request->financial_catergory_code_id))
        {
            return 'true';
        }
    }

}
