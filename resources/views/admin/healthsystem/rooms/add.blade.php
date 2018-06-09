@extends('layouts.app')

@section('head')
@parent
@endsection
@section('page_title','Add a Room')
@section('page_description','add room here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add room for {{$department->name}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/departments/'.$department->id.'/rooms/create', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('room_number', 'Room Number:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('room_number', $value = '', ['class' => 'form-control', 'placeholder' => 'Room Number']) !!}
                  </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('room_type', 'Room Type:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('room_type', $value = '', ['class' => 'form-control', 'placeholder' => 'room type']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('is_clinical', 'Is Clinical', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('is_clinical',['-1' => 'Please Select','1' => 'Yes','0' => 'No'], $value = '', ['class' => 'form-control selectpicker']) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('square_ft', 'Square Ft:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('square_ft', $value = '', ['class' => 'form-control', 'placeholder' => 'Square Ft']) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('bar_code', 'Bar Code:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('bar_code', $value = '', ['class' => 'form-control', 'placeholder' => 'Bar Code']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('sprinkled_pct', 'Sprinkled Percentage %:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('sprinkled_pct', $value = '', ['class' => 'form-control', 'placeholder' => 'Sprinkled %']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('beds', 'Beds:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('beds', $value = '', ['class' => 'form-control', 'placeholder' => 'No of beds']) !!}
                  </div>
            </div>

            <div class="form-group">
                  {!! Form::label('unused_space_sq_ft', 'Unused Space Sq Ft:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('unused_space_sq_ft', $value = '', ['class' => 'form-control', 'placeholder' => 'Unused Space Sq Ft']) !!}
                  </div>
            </div>


            <div class="form-group">
                  {!! Form::label('operating_rooms', 'Operating Rooms:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('operating_rooms', $value = '', ['class' => 'form-control', 'placeholder' => 'Operating Rooms']) !!}
                  </div>
            </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/buildings/'.$department->building->id.'/departments/'.$department->id.'/rooms', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Room', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>
            {!! Form::hidden('building_department_id', $department->id) !!}
            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      


    </div>

@endsection
