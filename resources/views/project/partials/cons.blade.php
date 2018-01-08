{!! Form::open(['url' => 'projects/con/edit/'.$project->id, 'class' => 'form-horizontal']) !!}


<div class="form-group">
    {!! Form::label('is_new_dialysis_or_home_services', 'Establishment of new dialysis services or home health services? ', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_new_dialysis_or_home_services', ['0' => 'No', '1' => 'Yes'],$project->is_new_dialysis_or_home_services, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_misc_services', 'The offering of any of the following services ', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_misc_services', ['none' => 'None', 'bone_marrow_transplantation' => 'Bone Marrow Transplantation','burn_intensive_care_services' => 'Burn intensive care services','neonatical_intensive_care_services' => 'Neonatal intensive care services (NICU)','open_heart_surgery_services' => 'Open-heart surgery services','solid_organ_transplantation_services' => 'Solid organ transplantation services','cardiac_catheterization_services' => 'Cardiac catheterization services'],$project->is_misc_services, ['placeholder' => 'Select One','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_misc_equipment', 'The acquisition of any of the following equipment ', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_misc_equipment', ['none' => 'None', 'cardiac_catheterization_equipment' => 'Cardiac catheterization equipment','gamma_knife_equipment' => 'Gamma knife equipment','heart_lung_bypass_machine' => 'Heart-lung bypass machine','linear_accelerator' => 'Linear Accelerator','lithotriptor' => 'Lithotriptor','magnetic_resonance_imaging_scanner' => 'Magnetic Resonance Imaging Scanner','pet_scanner' => 'Positron Emission Tomography (PET) Scanner','simulator' => 'Simulator'],$project->is_new_dialysis_or_home_services, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_health_service_facility_from_health_maintenance_org', 'Are you acquiring a health service facility from a health maintenance organization? ', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_health_service_facility_from_health_maintenance_org', ['0' => 'No', '1' => 'Yes'],$project->is_health_service_facility_from_health_maintenance_org, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_healthcare_beds_to_non_healthcarebeds', 'Are you converting healthcare beds to non-healthcare beds?', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_healthcare_beds_to_non_healthcarebeds', ['0' => 'No', '1' => 'Yes'],$project->is_healthcare_beds_to_non_healthcarebeds, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_construction_or_establishment', 'Construction development or establishment of a hospice, hospice inpatient facility, or hospice residential care facility?', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_construction_or_establishment', ['0' => 'No', '1' => 'Yes'],$project->is_construction_or_establishment, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_opening_additional_office', 'Opening of an additional office by an existing home health agency or hospice', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_opening_additional_office', ['0' => 'No', '1' => 'Yes'],$project->is_opening_additional_office, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_acquisition_of_major_medical_equipment', 'Acquisition of major medical equipment ($750,000 including cost of studies, design, construction, renovation, and installation)', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_acquisition_of_major_medical_equipment', ['0' => 'No', '1' => 'Yes'],$project->is_acquisition_of_major_medical_equipment, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_relocation_of_health_service_facility', 'Relocation of a health service facility from one service area to another', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_relocation_of_health_service_facility', ['0' => 'No', '1' => 'Yes'],$project->is_relocation_of_health_service_facility, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_converted_to_multispeciality_surgical_program', 'Conversion of a specialty ambulatory surgical program to a multispecialty surgical program or the addition of a specialty to a specialty ambulatory surgical program', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_converted_to_multispeciality_surgical_program', ['0' => 'No', '1' => 'Yes'],$project->is_converted_to_multispeciality_surgical_program, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_furnishing_mobile_medical_equipment', 'Furnishing mobile medical equipment to any person in the state if not in use prior to March 18, 1993', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_furnishing_mobile_medical_equipment', ['0' => 'No', '1' => 'Yes'],$project->is_furnishing_mobile_medical_equipment, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_gastrointestinal_or_operation_change_v1', 'The construction, development, establishment, increase in the number, or relocation of an operating room or gastrointestinal endoscopy room in a licensed health service facility, other than relocation within the same building or on the same grounds or to grounds not separated by more than the public right of way from existing location', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_gastrointestinal_or_operation_change_v1', ['0' => 'No', '1' => 'Yes'],$project->is_gastrointestinal_or_operation_change_v1, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_gastrointestinal_or_operation_change_v2', 'The change in designation, in a licensed health service facility, of an operating room to a gastrointestinal endoscopy room or change in designation of a gastrointestinal endoscopy room to an operating room that results in a different number of each type of room that is reflected on the health service facilities license in effect as of January 1, 2005', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_gastrointestinal_or_operation_change_v2', ['0' => 'No', '1' => 'Yes'],$project->is_gastrointestinal_or_operation_change_v2, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
        {!! Form::label('possession_letter_documents_path', 'A letter from the person taking possession of the existing equipment that acknowledges the existing equipment: will be permanently removed from the State, will no longer be exempt from requirements of the States Certificate of Need law, and will not be used in the State without first obtaining a new certificate of need.', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! HTML::dropzone('possession_letter_documents_path',(empty($project->possession_letter_documents_path)) ? 'projects/possession_letter_documents_path/'.Auth::guard('system_user')->user()->healthsystem_id.'-'.$project->id : $project->possession_letter_documents_path,'true') !!}
    </div>
</div>

<div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                  {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                  {!! Form::submit('Save CON Details', ['class' => 'btn btn-success pull-right'] ) !!}
              </div>
          </div>
      </fieldset>


















{!! Form::close()  !!}