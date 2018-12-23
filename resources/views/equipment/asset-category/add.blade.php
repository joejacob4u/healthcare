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
        {!! Form::open(['url' => '/admin/equipment/categories/'.$category->id.'/asset-categories', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Maintenance Asset Category:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', Request::old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Category']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('pm_procedure', 'PM Procedure:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('pm_procedure', Request::old('pm_procedure'), ['class' => 'form-control', 'placeholder' => 'PM Procedure','rows' => '4']) !!}
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
                    {!! Form::label('system_tier_id', 'System Tier:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('system_tier_id', $system_tiers->prepend('Please select',0), Request::old('system_tier_id'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('equipment_physical_risk_id', 'Physical Risk:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('equipment_physical_risk_id', $physical_risks, Request::old('maintenance_physical_risk_id'), ['class' => 'form-control selectpicker','id' => 'maintenance_physical_risk_id']) !!}
                    </div>
                </div>

                 <div class="form-group">
                    {!! Form::label('equipment_utility_function_id', 'Utility Function:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('equipment_utility_function_id', $utility_functions, Request::old('equipment_utility_function_id'), ['class' => 'form-control selectpicker','id' => 'maintenance_utility_function_id']) !!}
                    </div>
                </div>



                <div class="form-group">
                    {!! Form::label('eop_id', 'EOP:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('eop_id[]', $eops, Request::old('eop_id'), ['class' => 'form-control selectpicker','multiple' => true,'id' => 'eop_id','data-live-search' => 'true','data-size' => 'false']) !!}
                    </div>
                </div>







                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/equipment/categories/'.$category->id.'/asset-categories','Cancel', ['class' => 'btn btn-warning'] ) !!}
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



    </script>

@endsection
