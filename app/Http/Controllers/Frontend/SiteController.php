<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\HCO;
use App\Regulatory\Site;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }
    
    public function index($hco_id)
    {
        $hco = HCO::find($hco_id);
        return view('frontend.healthsystem.sites.index', ['hco' => $hco]);
    }

    public function add($hco_id)
    {
        $hco = HCO::find($hco_id);
        return view('frontend.healthsystem.sites.add', ['hco' => $hco]);
    }

    public function create(Request $request, $hco_id)
    {
        $this->validate($request, [
        'name' => 'required',
        'site_id' => 'required|unique:sites',
        'address' => 'required',
      ]);

        $hco = HCO::find($hco_id);

        if ($hco->sites()->create($request->all())) {
            return redirect('hco/'.$hco_id.'/sites')->with('success', 'New site added!');
        }
    }

    public function edit($hco_id, $id)
    {
        $site = Site::find($id);
        $hco = HCO::find($hco_id);
        return view('frontend.healthsystem.sites.edit', ['site' => $site,'hco' => $hco]);
    }

    public function save(Request $request, $hco_id, $id)
    {
        $this->validate($request, [
        'name' => 'required',
        'site_id' => 'required',
        'address' => 'required',
      ]);

        $hco = HCO::find($hco_id);

        if ($hco->sites()->where('id', $id)->update(request()->except(['_token']))) {
            return redirect('hco/'.$hco_id.'/sites')->with('success', 'Site updated!');
        }
    }

    public function delete(Request $request)
    {
        if (Site::destroy($request->id)) {
            return 'true';
        }
    }
}
