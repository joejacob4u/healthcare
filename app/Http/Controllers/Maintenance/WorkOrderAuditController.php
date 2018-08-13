<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\WorkOrderAudit;

class WorkOrderAuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }
    public function index()
    {
        $work_order_audits = WorkOrderAudit::get();
        return view('maintenance.work-order-audit', ['work_order_audits' => $work_order_audits]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:maintenance_work_order_audits,name',
        ]);

        if (WorkOrderAudit::create($request->all())) {
            return back()->with('success', 'Work order audit created!');
        }
    }

    public function delete(Request $request)
    {
        WorkOrderAudit::destroy($request->id);
        return 'true';
    }
}
