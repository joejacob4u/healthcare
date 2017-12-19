{!! Form::open(['url' => 'projects/financial/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('equipment_purchase_order_amount', 'Equipment Purchase Orders or Equipment ROM Estimate:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('equipment_purchase_order_amount', $project->equipment_purchase_order_amount, ['class' => 'form-control', 'placeholder' => 'Project Purpose']) !!}
    </div>
</div>

<div class="form-group">
        {!! Form::label('equipment_purchase_order_documents_path', 'Equipment Purchase Orders Files', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! HTML::dropzone('equipment_purchase_order_documents_path',(empty($project->equipment_purchase_order_documents_path)) ? 'projects/equipment_purchase_order_documents_path/'.Auth::guard('system_user')->user()->healthsystem_id.'-'.$project->id : $project->equipment_purchase_order_documents_path,'true') !!}
    </div>
</div>

<div class="form-group">
        {!! Form::label('copy_of_the_title_documents_path', 'Copy of the Title or Lease', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! HTML::dropzone('copy_of_the_title_documents_path',(empty($project->copy_of_the_title_documents_path)) ? 'projects/copy_of_the_title_documents_path/'.Auth::guard('system_user')->user()->healthsystem_id.'-'.$project->id : $project->copy_of_the_title_documents_path,'true') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('rom_construction_cost', '(ROM) Cost of Construction:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('rom_construction_cost', $project->rom_construction_cost, ['class' => 'form-control', 'placeholder' => '(ROM) Cost of Construction']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('business_unit_name', 'Business Unit/Cost Center:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('business_unit_name', $project->business_unit_name, ['class' => 'form-control', 'placeholder' => 'Business Unit/Cost Center']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('capital_id_number', 'Capital ID #:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('capital_id_number', $project->capital_id_number, ['class' => 'form-control', 'placeholder' => 'Capital ID #']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('fip_project_number', 'FIP Project #:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('fip_project_number', $project->fip_project_number, ['class' => 'form-control', 'placeholder' => 'FIP Project #:']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ecp_project_number', 'ECP Project #:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('ecp_project_number', $project->ecp_project_number, ['class' => 'form-control', 'placeholder' => 'ECP Project #:']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('account_code_number', 'Account Code (CIP) #:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('account_code_number', $project->account_code_number, ['class' => 'form-control', 'placeholder' => 'Account Code (CIP) #:']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('capital_project_id', 'Capital Project Type:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('capital_project_id', $project_types,$project->capital_project_id, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('funding_source', 'Funding Source:', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('funding_source', $project->funding_source, ['class' => 'form-control', 'placeholder' => 'Funding Source:']) !!}
    </div>
</div>

<div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                  {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                  {!! Form::submit('Save Financial Details', ['class' => 'btn btn-success pull-right'] ) !!}
              </div>
          </div>
      </fieldset>



{!! Form::close()  !!}
