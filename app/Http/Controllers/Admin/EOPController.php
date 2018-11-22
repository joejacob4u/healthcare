<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;
use App\Regulatory\EOP;
use App\Regulatory\SubCOP;
use App\Regulatory\Accreditation;

class EOPController extends Controller
{
    public function index($standard_label)
    {
        $standard_label = StandardLabel::find($standard_label);
        return view('admin.eop.index', ['standard_label' => $standard_label]);
    }

    public function create($standard_label)
    {
        $standard_label = StandardLabel::find($standard_label);
        $accreditations = Accreditation::pluck('name', 'id');
        $cops = SubCOP::pluck('label', 'id');
        return view('admin.eop.add', ['standard_label' => $standard_label,'cops' => $cops->prepend('No COPs', 'no_cops'),'occupancy_types' => $this->occupancy_types(),'accreditations' => $accreditations]);
    }

    public function store(Request $request, $standard_label)
    {
        $this->validate($request, [
          'name' => 'required',
          'text' => 'required',
          'documentation' => 'required',
          'frequency' => 'required',
          'risk' => 'required',
          'occupancy_type' => 'required',
          'accreditations' => 'required|array',
          'accreditations.*' => 'exists:accreditation,id'
        ]);

        $standardLabel = StandardLabel::find($standard_label);



        if ($eop = $standardLabel->eops()->create($request->all())) {
            foreach ($request->accreditations as $accreditation) {
                $aAccreditations[] = Accreditation::find($accreditation);
            }

            $eop->accreditations()->saveMany($aAccreditations);

            if (!empty($request->cops)) {
                foreach ($request->cops as $cop) {
                    $aCops[] = SubCOP::find($cop);
                }

                $eop->subCOPs()->saveMany($aCops);
            }

            return redirect('admin/standard-label/'.$standard_label.'/eop')->with('success', 'EOP created successfully');
        }
    }

    public function edit($standard_label, $eop)
    {
        $standard_label = StandardLabel::find($standard_label);
        $eop = EOP::find($eop);
        $cops = SubCOP::pluck('label', 'id');
        $accreditations = Accreditation::pluck('name', 'id');
        return view('admin.eop.edit', ['standard_label' => $standard_label, 'eop' => $eop,'cops' => $cops->prepend('No COPs', 'no_cops'),'occupancy_types' => $this->occupancy_types(),'accreditations' => $accreditations]);
    }

    public function save(Request $request, $standard_label, $eop)
    {
        $this->validate($request, [
          'name' => 'required',
          'text' => 'required',
          'documentation' => 'required',
          'frequency' => 'required',
          'risk' => 'required',
          'occupancy_type' => 'required',
          'accreditations' => 'required|array',
          'accreditations.*' => 'exists:accreditation,id'
        ]);

        $standardLabel = StandardLabel::find($standard_label);
        $eop = EOP::find($eop);
        $eop->update($request->all());

        if ($standardLabel->eops()->save($eop)) {
            foreach ($request->accreditations as $accreditation) {
                $aAccreditations[] = Accreditation::find($accreditation)->id;
            }

            $eop->accreditations()->sync($aAccreditations);

            if (!empty($request->cops)) {
                foreach ($request->cops as $cop) {
                    $aCops[] = SubCOP::find($cop)->id;
                }

                if ($eop->subCOPs()->sync($aCops)) {
                    return redirect('admin/standard-label/'.$standard_label.'/eop')->with('success', 'EOP saved successfully');
                }
            } else {
                return redirect('admin/standard-label/'.$standard_label.'/eop')->with('success', 'EOP saved successfully');
            }
        }
    }

    public function delete($standard_label, $eop)
    {
        if (EOP::destroy($eop)) {
            return redirect('admin/standard-label/'.$standard_label.'/eop')->with('error', 'EOP deleted successfully');
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
