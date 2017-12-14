@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Project')
@section('page_description','Add a Project Here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add a Project (General Information)</h3>
      </div>
      <div class="box-body">
     
      {!! Form::open(['url' => 'projects/general/store', 'class' => 'form-horizontal']) !!}
      <fieldset>
        <div class="form-group">
            {!! Form::label('project_name', 'Project Name:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('project_name', $value = null, ['class' => 'form-control', 'placeholder' => 'Project Name']) !!}
            </div>
        </div>
      <div class="form-group">
          {!! Form::label('project_description', 'Project Description:', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('project_description', $value = null, ['class' => 'form-control', 'placeholder' => 'Project Description']) !!}
          </div>
      </div>
      <div class="form-group">
          {!! Form::label('project_purpose', 'Project Purpose:', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('project_purpose', $value = null, ['class' => 'form-control', 'placeholder' => 'Project Purpose']) !!}
          </div>
      </div>
      <div class="form-group">
          {!! Form::label('is_con', 'Require CON?:', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('is_con', ['0' => 'No', '1' => 'Yes'], null, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('is_new_service_facility', 'Is the project establishing a new health service facility?', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('is_new_service_facility', ['0' => 'No', '1' => 'Yes'], null, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('is_change_in_bed_capacity', 'Is there a change in bed capacity?', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('is_change_in_bed_capacity', ['0' => 'No', '1' => 'Yes'], null, ['placeholder' => 'Select Yes/No','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('project_information_documents_path', 'Project Information Documents', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! HTML::dropzone('project_information_documents_path','projects/project_information_documents_path/'.Auth::guard('system_user')->user()->healthsystem_id.'_'.strtotime('now'),'false') !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('project_photos_directory', 'Project Photos', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! HTML::dropzone('project_photos_directory','projects/project_photos_directory/'.Auth::guard('system_user')->user()->healthsystem_id.'_'.strtotime('now'),'false') !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('hco_id', 'HCO', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('hco_id', $hcos, null, ['placeholder' => 'Select HCO','class' => 'form-control','id' => 'hco_id']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('site_id', 'Site', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('site_id', [], null, ['placeholder' => 'Select Site','class' => 'form-control','disabled' => true,'id' => 'site_id']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('buildings', 'Buildings', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('buildings[]', [], null, ['placeholder' => 'Buildings','class' => 'form-control','disabled' => true,'id' => 'buildings','multiple' => true]); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('project_target_date', 'Project Target Date', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::date('project_target_date', $value = null, ['class' => 'form-control', 'placeholder' => 'Project Tarhget Date']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('construction_start_date', 'Construction Start Date', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::date('construction_start_date', $value = null, ['class' => 'form-control', 'placeholder' => 'Construction Start Date']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('construction_end_date', 'Construction End Date', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::date('construction_end_date', $value = null, ['class' => 'form-control', 'placeholder' => 'Construction End Date']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('project_webcam', 'Project Webcam:', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('project_webcam', $value = null, ['class' => 'form-control', 'placeholder' => 'Project Webcam']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('status_indicator', 'Status Indicator', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('status_indicator', ['red' => 'Red', 'green' => 'Green','yellow' => 'Yellow'], null, ['placeholder' => 'Status Indicator','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('project_specific_links', 'Project Specific Links', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::textarea('project_specific_links', $value = null, ['class' => 'form-control', 'placeholder' => 'Project Specific Links']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('project_number', 'Project Number', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::number('project_number', $value = null, ['class' => 'form-control', 'placeholder' => 'Project Number']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('project_type_id', 'Project Type', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('project_type', ['renovation' => 'Renovation','new_construction' => 'New Construction','demolition' => 'demolition','equipment_only' => 'Equipment Only'], null, ['placeholder' => 'Capital Project Type','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('architecture_firm_contractor_id', 'Architecture Firm', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('architecture_firm_contractor_id',$health_system->contractorType('Electrical Engineer')->pluck('name','id'), null, ['placeholder' => 'Architecture Firm','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('engineer_firm_contractor_id', 'Engineer Firm', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('engineer_firm_contractor_id', [], null, ['placeholder' => 'Engineer Firm','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('construction_manager_contractor_id', 'Construction Manager', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('construction_manager_contractor_id', [], null, ['placeholder' => 'Construction Manager','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('general_contractor_contractor_id', 'General Contractor', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('general_contractor_contractor_id', [], null, ['placeholder' => 'General Contractor','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('trade_contractor_contractor_id', 'Trade Contractor', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('trade_contractor_contractor_id', [], null, ['placeholder' => 'Trade Contractor','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('med_equipment_manager_contractor_id', 'Med Equipment Manager', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('med_equipment_manager_contractor_id', [], null, ['placeholder' => 'Med Equipment Manager','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('med_equipment_manager_contractor_id', 'Med Equipment Manager', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('med_equipment_manager_contractor_id', [], null, ['placeholder' => 'Med Equipment Manager','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('commissioning_agent_contractor_id', 'Commissioning Agent', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::select('commissioning_agent_contractor_id', [], null, ['placeholder' => 'Commissioning Agent','class' => 'form-control']); !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('furniture_firm', 'Furniture Firm:', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('furniture_firm', $value = null, ['class' => 'form-control', 'placeholder' => 'Furniture Firm']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('gross_sq_ft_project_completion', 'Gross Square Feet at Project Completion:', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('gross_sq_ft_project_completion', $value = null, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('gross_sq_ft_added_cost_center', 'Square Feet Added to this projects Cost Center:', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('gross_sq_ft_added_cost_center', $value = null, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('sq_ft_removed_cost_center', 'Square Feet removed from cost center', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('sq_ft_removed_cost_center', $value = null, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('cost_center_losing_adding_sq_ft', 'Cost Center Losing or Adding Square Feet', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('cost_center_losing_adding_sq_ft', $value = null, ['class' => 'form-control', 'placeholder' => 'Gross Square Feet']) !!}
          </div>
      </div>

      <div class="form-group">
          {!! Form::label('ahj', 'Authority Having Jurisdiction', ['class' => 'col-lg-2 control-label']) !!}
          <div class="col-lg-10">
              {!! Form::text('ahj', $value = null, ['class' => 'form-control', 'placeholder' => 'AHJ']) !!}
          </div>
      </div>


          <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                  {{ link_to('admin/cop', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                  {!! Form::submit('Add Project', ['class' => 'btn btn-success pull-right'] ) !!}
              </div>
          </div>
      </fieldset>

  {!! Form::close()  !!}

<script>

$( "#hco_id" ).change(function() {
  $.ajax({
    type: "POST",
    url: "{{url('project/fetch/sites')}}",
    data: {'_token' : '{{ csrf_token() }}','hco_id' : $(this).val()},
    beforeSend:function()
    {
      $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    },
    success:function(data)
    {
      var html = '';

      $.each(data.sites, function(index, value) {
          html += '<option value="'+value.id+'">'+value.name+'</option>';
      });

      $('#site_id').html('');
      $('#site_id').prop('disabled',false);
      $('#site_id').append(html);
    },
    error:function()
    {
      // failed request; give feedback to user
    },
    complete: function(data)
    {
        $('.overlay').remove();
    }
  });
});

$( "#site_id" ).click(function() {
  $.ajax({
    type: "POST",
    url: "{{url('project/fetch/buildings')}}",
    data: {'_token' : '{{ csrf_token() }}','site_id' : $(this).val()},
    beforeSend:function()
    {
      $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    },
    success:function(data)
    {
      var html = '';
      
      $.each(data.buildings, function(index, value) {
          html += '<option value="'+value.id+'">'+value.name+'</option>';
      });

      $('#buildings').html('');
      $('#buildings').prop('disabled',false);
      $('#buildings').append(html);
    },
    error:function()
    {
      // failed request; give feedback to user
    },
    complete: function(data)
    {
        $('#buildings').selectpicker('refresh');
        $('.overlay').remove();
    }
  });
});

</script>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>


@endsection

