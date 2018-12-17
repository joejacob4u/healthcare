<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\Site;
use App\Regulatory\Building;
use App\Regulatory\Accreditation;
use Storage;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('system_admin');
    }
    
    public function index($site_id)
    {
        $site = Site::find($site_id);
        return view('frontend.healthsystem.buildings.index', ['site' => $site]);
    }

    public function add($site_id)
    {
        $site = Site::find($site_id);
        $accreditations = $site->hco->accreditations->pluck('name', 'id');
        return view('frontend.healthsystem.buildings.add', ['site' => $site,'occupancy_types' => $this->occupancy_types(),'ownership_types' => $this->lease_types(),'accreditations' => $accreditations]);
    }

    public function create(Request $request, $site_id)
    {
        $this->validate($request, [
          'name' => 'required',
          'building_id' => 'required|unique:buildings',
          'occupancy_type' => 'required',
          'accreditations' => 'not_in:0',
          'ownership' => 'required',

        ]);

        $site = Site::find($site_id);

        foreach ($request->accreditations as $accreditation) {
            $aAccreditations[] = Accreditation::find($accreditation);
        }


        $path = '';
        
        if ($request->hasFile('building_logo_image')) {
            $path = $request->file('building_logo_image')->store('logo/building', 's3');
        }
        
        $request->request->add(['building_logo' => $path]);
        

        if ($building = $site->buildings()->create($request->all())) {
            if ($building->accreditations()->saveMany($aAccreditations)) {
                return redirect('sites/'.$site_id.'/buildings')->with('success', 'Building added!');
            }
        }
    }

    public function edit($site_id, $id)
    {
        $site = Site::find($site_id);
        $building = Building::find($id);
        $accreditations = $site->hco->accreditations->pluck('name', 'id');
        return view('frontend.healthsystem.buildings.edit', ['site' => $site,'building' => $building,'occupancy_types' => $this->occupancy_types(),'ownership_types' => $this->lease_types(),'accreditations' => $accreditations]);
    }

    public function save(Request $request, $site_id, $id)
    {
        $this->validate($request, [
          'name' => 'required',
          'building_id' => 'required',
          'occupancy_type' => 'required',
          'accreditations' => 'not_in:0',
          'ownership' => 'required',
        ]);

        $site = Site::find($site_id);

        foreach ($request->accreditations as $accreditation) {
            $aAccreditations[] = Accreditation::find($accreditation)->id;
        }

        $path = '';

        if ($request->hasFile('building_logo_image')) {
            $path = $request->file('building_logo_image')->store('logo/building', 's3');
        }
        
        $request->request->add(['building_logo' => $path]);

        $building = Building::find($id);
         


        if ($site->buildings()->where('id', $id)->update(request()->except(['_token','accreditations']))) {
            if ($building->accreditations()->sync($aAccreditations)) {
                return redirect('sites/'.$site_id.'/buildings')->with('success', 'Building updated !');
            }
        }
    }

    public function delete(Request $request)
    {
        if (Building::destroy($request->id)) {
            return 'true';
        }
    }

    public function fetchDepartments(Request $request)
    {
        $building = Building::find($request->building_id);
        return response()->json(['departments' => $building->departments]);
    }

    public function uploadImages(Request $request)
    {
        $dir = 'building_images/'.uniqid();
        $path = $request->file('buildingimages')->store($dir, 's3');
        return $dir;
    }

    public function fetchImages(Request $request)
    {
        return Storage::disk('s3')->files($request->directory);
    }


    public function occupancy_types()
    {
        return [
        'assembly_a-1' => 'Assembly A-1',
        'assembly_a-2' => 'Assembly A-2',
        'assembly_a-3' => 'Assembly A-3',
        'assembly_a-4' => 'Assembly A-4',
        'assembly_a-5' => 'Assembly A-5',
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

    public function lease_types()
    {
        return [
        'owned' => 'Owned',
        'nnn_lease' => 'NNN Lease',
        'nn_lease' => 'NN Lease',
        'n_lease' => 'N Lease',
        'absolute_nnn_lease' => 'Absolute NNN Lease',
        'modified_grose_lease' => 'Modified Gross Lease',
        'full_service_lease' => 'Full Service Lease',
        'sold' => 'Sold'
      ];
    }
}
