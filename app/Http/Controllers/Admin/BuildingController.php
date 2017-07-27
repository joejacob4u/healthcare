<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Site;
use App\Regulatory\Building;

class BuildingController extends Controller
{
    public function index($site_id)
    {
        $site = Site::find($site_id);
        return view('admin.healthsystem.buildings.index',['site' => $site]);
    }

    public function add($site_id)
    {
      $site = Site::find($site_id);
      return view('admin.healthsystem.buildings.add',['site' => $site,'occupancy_types' => $this->occupancy_types()]);
    }

    public function create(Request $request,$site_id)
    {
      $this->validate($request,[
        'name' => 'required',
        'building_id' => 'required|unique:buildings',
        'occupancy_type' => 'required',
        'square_ft' => 'required'
      ]);

        $site = Site::find($site_id);

        if($site->buildings()->create($request->all()))
        {
          return redirect('admin/sites/'.$site_id.'/buildings')->with('success','Buliding added!');
        }
    }

    public function edit($site_id,$id)
    {
        $site = Site::find($site_id);
        $building = Building::find($id);
        return view('admin.healthsystem.buildings.edit',['site' => $site,'building' => $building,'occupancy_types' => $this->occupancy_types()]);
    }

    public function save(Request $request,$site_id,$id)
    {
        $this->validate($request,[
          'name' => 'required',
          'building_id' => 'required',
          'occupancy_type' => 'required',
          'square_ft' => 'required'
        ]);

        $site = Site::find($site_id);

        if($site->buildings()->where('id',$id)->update(request()->except(['_token'])))
        {
          return redirect('admin/sites/'.$site_id.'/buildings')->with('success','Building updated !');
        }
    }

    public function delete(Request $request)
    {
      if(Building::destroy($request->id))
      {
        return 'true';
      }
    }


    public function occupancy_types()
    {
      return [
        'assembly-a-1' => 'Assembly A-1',
        'assembly-a-2' => 'Assembly A-2',
        'assembly-a-3' => 'Assembly A-3',
        'assembly-a-4' => 'Assembly A-4',
        'assembly-a-5' => 'Assembly A-5',
        'business_b' => 'Business B',
        'educational_e' => 'Educational E',
        'factory_f1' => 'Factory F1',
        'factory_f2' => 'Factory F2',
        'high_hazard_h1' => 'High Hazard H1',
        'high_hazard_h2' => 'High Hazard H2',
        'high_hazard_h3' => 'High Hazard H3',
        'high_hazard_h4' => 'High Hazard H4',
        'high_hazard_h5' => 'High Hazard H5',
        'institutional_i1' => 'Institutional I1',
        'institutional_i2' => 'Institutional I2',
        'institutional_i3' => 'Institutional I3',
        'institutional_i4' => 'Institutional I4',
        'mercantile_m' => 'Mercantile M',
        'residential_r1' => 'Residential R1',
        'residential_r2' => 'Residential R2',
        'residential_r3' => 'Residential R3',
        'residential_r4' => 'Residential R4',
        'storage_s1' => 'Storage s1',
        'storage_s2' => 'Storage s2',
        'utility_misc' => 'Utility and Misc'
      ];
    }

}
