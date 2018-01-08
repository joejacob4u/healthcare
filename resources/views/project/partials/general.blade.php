{!! Form::open(['url' => 'projects/general/edit/'.$project->id, 'class' => 'form-horizontal']) !!}
<fieldset>
  <div class="form-group">
      {!! Form::label('project_name', 'Project Name:', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
          {!! Form::text('project_name', $project->project_name, ['class' => 'form-control', 'placeholder' => 'Project Name']) !!}
      </div>
  </div>
<div class="form-group">
    {!! Form::label('project_description', 'Project Description:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('project_description', $project->project_description, ['class' => 'form-control', 'placeholder' => 'Project Description']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('project_purpose', 'Project Purpose:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('project_purpose', $project->project_purpose, ['class' => 'form-control', 'placeholder' => 'Project Purpose']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('is_con', 'Require CON?:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_con', ['0' => 'No', '1' => 'Yes'], $project->is_con, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_new_service_facility', 'Is the project establishing a new health service facility?', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_new_service_facility', ['0' => 'No', '1' => 'Yes'],$project->is_new_service_facility, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('is_change_in_bed_capacity', 'Is there a change in bed capacity?', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('is_change_in_bed_capacity', ['0' => 'No', '1' => 'Yes'], $project->is_change_in_bed_capacity, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_information_documents_path', 'Project Information Documents (Brochures or letters from the vendors describing the capabilities of existing and replacement equipment) ', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! HTML::dropzone('project_information_documents_path',$project->project_information_documents_path,'true') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_photos_directory', 'Project Photos', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! HTML::dropzone('project_photos_directory',$project->project_photos_directory,'true') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('hco_id', 'HCO', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('hco_id', $hcos, $project->hco_id, ['placeholder' => 'Select HCO','class' => 'form-control','id' => 'hco_id']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('site_id', 'Site', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('site_id', $sites, $project->site_id, ['placeholder' => 'Select Site','class' => 'form-control','id' => 'site_id']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('buildings', 'Buildings', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('buildings[]', $buildings, $project->buildings->pluck('id'), ['placeholder' => 'Buildings','class' => 'form-control','id' => 'buildings','multiple' => true]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_target_date', 'Project Target Date', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::date('project_target_date', $project->project_target_date, ['class' => 'form-control', 'placeholder' => 'Project Tarhget Date']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('construction_start_date', 'Construction Start Date', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::date('construction_start_date', $project->construction_start_date, ['class' => 'form-control', 'placeholder' => 'Construction Start Date']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('construction_end_date', 'Construction End Date', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::date('construction_end_date', $project->construction_end_date, ['class' => 'form-control', 'placeholder' => 'Construction End Date']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_webcam', 'Project Webcam:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('project_webcam', $project->project_webcam, ['class' => 'form-control', 'placeholder' => 'Project Webcam']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('status_indicator', 'Status Indicator', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('status_indicator', ['red' => 'Red', 'green' => 'Green','yellow' => 'Yellow'], $project->status_indicator, ['placeholder' => 'Status Indicator','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_specific_links', 'Project Specific Links', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::textarea('project_specific_links', $project->project_specific_links, ['class' => 'form-control', 'placeholder' => 'Project Specific Links']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_number', 'Project Number', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::number('project_number', $project->project_number, ['class' => 'form-control', 'placeholder' => 'Project Number']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('project_type_id', 'Project Type', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('project_type', ['renovation' => 'Renovation','new_construction' => 'New Construction','demolition' => 'demolition','equipment_only' => 'Equipment Only'], $project->project_type_id, ['placeholder' => 'Capital Project Type','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('architecture_firm_contractor_id', 'Architecture Firm', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('architecture_firm_contractor_id',$health_system->contractorType('Architect')->pluck('name','id'), $project->architecture_firm_contractor_id, ['placeholder' => 'Architecture Firm','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('engineer_firm_contractor_id', 'Engineer Firm', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('engineer_firm_contractor_id', $health_system->contractorType('General Engineering Contractor')->pluck('name','id'), $project->engineer_firm_contractor_id, ['placeholder' => 'Engineer Firm','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('construction_manager_contractor_id', 'Construction Manager', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('construction_manager_contractor_id', $health_system->contractorType('Construction Manager, Project Manager')->pluck('name','id'), $project->construction_manager_contractor_id, ['placeholder' => 'Construction Manager','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('general_contractor_contractor_id', 'General Contractor', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('general_contractor_contractor_id', $health_system->contractorType('General Contractor')->pluck('name','id'), $project->general_contractor_contractor_id, ['placeholder' => 'General Contractor','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('trade_contractor_contractor_id', 'Trade Contractor', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('trade_contractor_contractor_id', $health_system->contractorType('General Building Contractor')->pluck('name','id'), $project->trade_contractor_contractor_id, ['placeholder' => 'Trade Contractor','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('med_equipment_manager_contractor_id', 'Med Equipment Manager', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('med_equipment_manager_contractor_id', $health_system->contractorType('General Building Contractor')->pluck('name','id'), $project->med_equipment_manager_contractor_id, ['placeholder' => 'Med Equipment Manager','class' => 'form-control']); !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('commissioning_agent_contractor_id', 'Commissioning Agent', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('commissioning_agent_contractor_id', $health_system->contractorType('General Building Contractor')->pluck('name','id'), $project->commissioning_agent_contractor_id, ['placeholder' => 'Commissioning Agent','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('furniture_firm', 'Furniture Firm:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('furniture_firm', $project->furniture_firm, ['class' => 'form-control', 'placeholder' => 'Furniture Firm']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('gross_sq_ft_project_completion', 'Gross Square Feet at Project Completion:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('gross_sq_ft_project_completion', $project->gross_sq_ft_project_completion, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('gross_sq_ft_added_cost_center', 'Square Feet Added to this projects Cost Center:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('gross_sq_ft_added_cost_center', $project->gross_sq_ft_added_cost_center, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('sq_ft_removed_cost_center', 'Square Feet removed from cost center', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('sq_ft_removed_cost_center', $project->sq_ft_removed_cost_center, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('cost_center_losing_adding_sq_ft', 'Cost Center Losing or Adding Square Feet', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('cost_center_losing_adding_sq_ft', $project->cost_center_losing_adding_sq_ft, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ahj', 'Authority Having Jurisdiction', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('ahj', $project->ahj, ['class' => 'form-control', 'placeholder' => 'AHJ']) !!}
    </div>
</div>


    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
            {!! Form::submit('Edit Project', ['class' => 'btn btn-success pull-right'] ) !!}
        </div>
    </div>
</fieldset>

{!! Form::close()  !!}
