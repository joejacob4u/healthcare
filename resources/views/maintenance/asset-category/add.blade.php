@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Maintenance Asset Category')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Maintenance Asset Category for {{$category->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => '/admin/maintenance/categories/'.$category->id.'/asset-categories', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Maintenance Asset Category:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', Request::old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Category']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('service_life', 'Service Life:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('service_life', Request::old('service_life'), ['class' => 'form-control', 'placeholder' => 'Service Life in months']) !!}
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
                        ], Request::old('required_by'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('maintenance_physical_risk_id', 'Physical Risk:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('maintenance_physical_risk_id', $physical_risks, Request::old('maintenance_physical_risk_id'), ['class' => 'form-control selectpicker','id' => 'maintenance_physical_risk_id']) !!}
                    </div>
                </div>

                 <div class="form-group">
                    {!! Form::label('maintenance_utility_function_id', 'Utility Function:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('maintenance_utility_function_id', $utility_functions, Request::old('maintenance_utility_function_id'), ['class' => 'form-control selectpicker','id' => 'maintenance_utility_function_id']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('accreditation_id', 'Accreditation:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('accreditation_id[]', $accreditations, Request::old('accreditation_id'), ['class' => 'form-control selectpicker','multiple' => true,'id' => 'accreditation_id']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('standard_label_id', 'Standard Label:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('standard_label_id[]', [], Request::old('standard_label_id'), ['class' => 'form-control selectpicker','placeholder' => 'Please select','id' => 'standard_label_id','multiple' => true]) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('eop_id', 'EOP:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('eop_id[]', [], Request::old('eop_id'), ['class' => 'form-control selectpicker','multiple' => true,'id' => 'eop_id']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('frequency', 'Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('frequency', ['0' => 'Please Select','no_frequency' => 'No Frequency','daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly','quarterly' => 'Quarterly','annually' => 'Annually','semi-annually' => 'Semi-anually','as_needed' => 'As Needed' ,'per_policy' => 'Per Policy','two-years' => 'Two Years', 'three-years' => 'Three Years', 'four-years' => 'Four Years', 'five-years' => 'Five Years', 'six-years' => 'Six Years'], Request::old('frequency'), ['class' => 'form-control','id' => 'frequency']) !!}
                    </div>
                </div>






                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/maintenance/categories/'.$category->id.'/asset-categories','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Add Maintenance Asset Category', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $('#eop_id').change(function(){
        var frequency = '';
        $('#eop_id > option:selected').each(function() {
            frequency = eop_array[$(this).val()];
        });

        $('#frequency option').each(function() {
            $(this).prop('disabled',false);
        });
        
        if(frequency){
            
            $('#frequency option').each(function() {
                if($(this).attr('value') == frequency)
                {
                    $('#frequency').val(frequency);
                }
                else
                {
                    $(this).prop('disabled',true);
                }
            });

        }


    });


    </script>

@endsection
