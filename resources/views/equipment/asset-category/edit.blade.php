@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Maintenance Asset Category')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Maintenance Asset Category for {{$asset_category->category->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => '/admin/equipment/categories/'.$asset_category->category->id.'/asset-categories/edit/'.$asset_category->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Maintenance Asset Category:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $asset_category->name, ['class' => 'form-control', 'placeholder' => 'Enter Category']) !!}
                  </div>
              </div>

                <div class="form-group">
                  {!! Form::label('pm_procedure', 'PM Procedure:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('pm_procedure', $asset_category->pm_procedure, ['class' => 'form-control', 'placeholder' => 'PM Procedure','rows' => '4']) !!}
                  </div>
              </div>



                <div class="form-group">
                    {!! Form::label('service_life', 'Service Life:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('service_life', $asset_category->service_life, ['class' => 'form-control', 'placeholder' => 'Service Life']) !!}
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    {!! Form::label('required_by', 'Required By:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('required_by', [
                          '0' => 'Please select',
                          'evs' => 'EVS',
                          'biomed' => 'Bio-Med',
                          'maintenance' => 'Maintenance',
                          'it' => 'Information Technology',
                          'grounds_maintenance' => 'Grounds Maintenance'
                        ], $asset_category->required_by, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('maintenance_physical_risk_id', 'Physical Risk:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('equipment_physical_risk_id', $physical_risks, $asset_category->equipment_physical_risk_id, ['class' => 'form-control selectpicker','id' => 'maintenance_physical_risk_id']) !!}
                    </div>
                </div>

                 <div class="form-group">
                    {!! Form::label('maintenance_utility_function_id', 'Utility Function:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('equipment_utility_function_id', $utility_functions, $asset_category->equipment_utility_function_id, ['class' => 'form-control selectpicker','id' => 'maintenance_utility_function_id']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('eop_id', 'EOP:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('eop_id[]', $eops, $asset_category->eops->pluck('id')->toArray(), ['class' => 'form-control selectpicker','multiple' => true,'id' => 'eop_id','data-live-search' => 'true','data-size' => 'false']) !!}
                    </div>
                </div>



                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/equipment/categories/'.$asset_category->category->id.'/asset-categories','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Update Maintenance Asset Category', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>

            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <script>

        $('#accreditation_id').change(function(){
        if($(this).val() != 0)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('accreditation/fetch/standard-labels') }}',
                data: { '_token' : '{{ csrf_token() }}', 'accreditations': JSON.stringify($('#accreditation_id').val()) },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#standard_label_id').html('');

                    var html = '<option value="0">Select Standard Label</option>';


                    $.each(data.standard_labels, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.label+'</option>';
                    });

                    $('#standard_label_id').append(html);
                    $('#standard_label_id').selectpicker('refresh');
                },
                complete:function()
                {
                    $('.overlay').remove();
                },
                error:function()
                {
                    // failed request; give feedback to user
                }
            });

        }


    });

    var eop_array = {};

    $('#standard_label_id').change(function(){
        
        eop_array = {};

        if($(this).val() != 0)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('standard-labels/fetch/eops') }}',
                data: { '_token' : '{{ csrf_token() }}', 'standard_labels': JSON.stringify($('#standard_label_id').val()) },
                beforeSend:function()
                {
                    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data)
                {
                    $('#eop_id').html('');

                    var html = '<option value="0">Select EOPs</option>';

                    $.each(data.eops, function(index, value) {
                        html += '<option value="'+value.id+'">'+value.name+'</option>';
                        eop_array[value.id] = value.frequency;
                    });

                    $('#eop_id').append(html);
                    $('#eop_id').selectpicker('refresh');
                },
                complete:function()
                {
                    $('.overlay').remove();
                },
                error:function()
                {
                    // failed request; give feedback to user
                }
            });

        }


    });

    </script>

@endsection
