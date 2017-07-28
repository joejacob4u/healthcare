@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add a Building')
@section('page_description','add building here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add building for {{$site->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/sites/'.$site->id.'/buildings/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('name', 'Building Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $value = '', ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                  </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('building_id', 'Building Id:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('building_id', $value = '', ['class' => 'form-control', 'placeholder' => 'id']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('accreditation_id', 'Accreditation:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                    {!! Form::select('accreditation_id', $accreditations, Request::old('accreditation_id'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('occupancy_type', 'Occupancy Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('occupancy_type', $occupancy_types, Request::old('occupancy_type'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                  </div>
              </div>



              <div class="form-group">
                  {!! Form::label('square_ft', 'Square Ft', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('square_ft', $value = '', ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('roof_sq_ft', 'Roof Square Ft', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('roof_sq_ft', $value = '', ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('ownership', 'Ownership Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('ownership', $ownership_types, Request::old('ownership'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('ownership_comments', 'Ownership Comments', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('ownership_comments', Request::old('ownership_comments'), ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('sprinkled_pct', 'Sprinkled Percentage', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('sprinkled_pct', Request::old('sprinkled_pct'), ['class' => 'form-control','data-provide' => 'slider','data-slider-min' => '0','data-slider-max' => '100','data-slider-step' => '5']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('beds', 'Beds', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('beds', Request::old('beds'), ['class' => 'form-control']) !!}
                  </div>
              </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/sites/'.$site->id.'/buildings', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Building', ['class' => 'btn btn-success pull-right'] ) !!}
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

@endsection
