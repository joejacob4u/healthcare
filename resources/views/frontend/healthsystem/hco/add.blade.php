@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in HCO for {{$healthsystem->healthcare_system}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'healthsystem/'.$healthsystem->id.'/hco/add', 'class' => 'form-horizontal','files' => true]) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('facility_name', 'Facility Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('facility_name', $value = '', ['class' => 'form-control', 'placeholder' => 'Facility Name']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('accreditations', 'Accreditations', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('accreditations[]',$accreditations->prepend('Please select accreditations', '0'), $value = '', ['class' => 'form-control selectpicker','multiple' => true]) !!}
                  </div>
              </div>


              <!-- Phone -->
              <div class="form-group">
                  {!! Form::label('address', 'Address:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('address', $value = '', ['class' => 'form-control', 'placeholder' => 'address']) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('hco_id', 'HCO ID', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('hco_id', $value = '', ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('is_need_state', 'Certification of Need State', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('is_need_state',['0' => 'No', '1' => 'Yes'], $value = '', ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('hco_logo', 'HCO Logo', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::file('hco_logo', ['class' => 'form-control','id' => 'hco_logo']) !!}
                  </div>
              </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('healthsystem/'.$healthsystem->id.'/hco', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add HCO Client', ['class' => 'btn btn-success pull-right'] ) !!}
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
