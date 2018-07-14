<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance\Trade;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Trade::get();
        return view('maintenance.trade.index', ['trades' => $trades]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:maintenance_trades,name'
        ]);

        if (Trade::create($request->all())) {
            return back()->with('success', 'New trade added.');
        }
    }

    public function delete(Request $request)
    {
        Trade::destroy($request->trade_id);
        return 'true';
    }
}
