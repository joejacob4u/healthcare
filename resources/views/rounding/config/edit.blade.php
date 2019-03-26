@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Configuration for Rounding')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

<ol class="breadcrumb">
    <li><a href="{{url('rounding/config')}}">Rounding Configs</a></li>
    <li>Edit</li>
</ol>


    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Configuration for Rounding</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'rounding/config/'.$config->id.'/edit', 'class' => 'form-horizontal']) !!}

            <fieldset>

                <div class="form-group">
                    {!! Form::label('building_department_id', 'Department:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('building_department_id', $departments->prepend('Please Select',''), $config->building_department_id, ['class' => 'form-control selectpicker','id' => 'building_department_id']) !!}
                    </div>
                </div>

                 <div class="form-group">
                    {!! Form::label('rounding_checklist_type_id', 'Checklist Type:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('rounding_checklist_type_id', $checklist_types->prepend('Please Select',''), $config->rounding_checklist_type_id, ['class' => 'form-control selectpicker','id' => 'rounding_checklist_type_id']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('user_id', 'User:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('user_id', $users->prepend('Please Select',''), $config->user_id, ['class' => 'form-control selectpicker','id' => 'user_id']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('frequency', 'Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('frequency', ['' => 'Please Select','daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly','quarterly' => 'Quarterly','annually' => 'Annually','semi-annually' => 'Semi-anually','as_needed' => 'As Needed' ,'per_policy' => 'Per Policy','two-years' => 'Two Years', 'three-years' => 'Three Years', 'four-years' => 'Four Years', 'five-years' => 'Five Years', 'six-years' => 'Six Years'], $config->frequency, ['class' => 'form-control selectpicker','id' => 'frequency','data-live-search' => 'true','data-size' => 'false']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('baseline_date', 'Baseline Date:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('baseline_date', $config->baseline_date, ['class' => 'date form-control', 'placeholder' => 'Enter Baseline Date']) !!}
                    </div>
                </div>

                {!! Form::hidden('building_id', $config->building_id,['id' => '']) !!}

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::submit('Edit Rounding Configuration', ['class' => 'btn btn-success pull-right'] ) !!}
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

    $('.date').flatpickr({
         enableTime: true,
         dateFormat: 'Y-m-d H:i:S',
         altInput: true,
         altFormat: 'M j, Y h:i K',
    });

    </script>

@endsection
