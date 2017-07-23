@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in HCO</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/hco/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <div class="form-group">
                  {!! Form::label('facility_name', 'Facility Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('facility_name', $value = '', ['class' => 'form-control', 'placeholder' => 'Facility Name']) !!}
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
                    {!! Form::label('healthsystem_id', 'Health System', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('healthsystem_id', $healthcare_systems,null,['class' => 'form-control']); !!}
                    </div>
                </div>



                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/clients', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
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
