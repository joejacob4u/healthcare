<?php

namespace App\Http\Controllers\Accreditation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\TJCChecklistEOP;

class TJCChecklistEOPController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'eop_id' => 'not_in:0',
            'is_in_policy' => 'not_in:0',
            'is_implemented_as_required' => 'not_in:0',
            'eoc_ls_status' => 'not_in:0'
        ]);

        if (TJCChecklistEOP::create($request->all())) {
            return back()->with('success', 'New eop configuration added !');
        }
    }
}
