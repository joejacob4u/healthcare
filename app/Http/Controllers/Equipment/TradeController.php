<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment\Trade;
use App\SystemTier;

class TradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $trades = Trade::get();
        $system_tiers = SystemTier::pluck('name', 'id');
        return view('maintenance.trade.index', ['trades' => $trades,'system_tiers' => $system_tiers]);
    }

    public function edit($trade_id)
    {
        $trade = Trade::find($trade_id);
        $system_tiers = SystemTier::pluck('name', 'id');
        return view('maintenance.trade.edit', ['trades' => $trades,'system_tiers' => $system_tiers]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:work_order_trades,name',
            'system_tier_id' => 'not_in:0'
        ]);

        if (Trade::create($request->all())) {
            return back()->with('success', 'New trade added.');
        }
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'system_tier_id' => 'not_in:0'
        ]);

        $trade = Trade::find($request->trade_id);

        if ($trade->update($request->except(['trade_id']))) {
            return back()->with('success', 'New trade updated!');
        }
    }


    public function delete(Request $request)
    {
        Trade::destroy($request->trade_id);
        return 'true';
    }
}
