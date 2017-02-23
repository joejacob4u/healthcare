@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Accreditation Requirement Info</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/accreditation/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('department_id', 'Department:', ['class' => 'col-lg-2 control-label'] )  !!}
                  <div class="col-lg-10">
                      {!!  Form::select('department_id', $departments, $selected = null, ['class' => 'form-control selectpicker']) !!}
                  </div>
              </div>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('label', 'Standard Label:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('label', $value = null, ['class' => 'form-control', 'placeholder' => 'Standard Label']) !!}
                  </div>
              </div>
                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('text', 'Standard Text:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('text', $value = null, ['class' => 'form-control', 'placeholder' => 'standard text']) !!}
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::button('Cancel', ['class' => 'btn btn-warning','href' => 'admin/client'] ) !!}
                        {!! Form::submit('Add Requirement', ['class' => 'btn btn-success pull-right'] ) !!}
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
