@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add a System Administrator</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'healthsystem/users/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('healthsystem_id', 'Healthcare System:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('healthsystem_id', $healthcare_systems, Request::old('healthsystem_id'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                  </div>
              </div>
                <!-- Email -->

                <div class="form-group">
                    {!! Form::label('prospect_id', 'Prospect:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('prospect_id', $prospects, Request::old('prospect_id'), ['class' => 'form-control','placeholder' => 'Please select']) !!}
                    </div>
                </div>


                {!! Form::hidden('role_id', '2'); !!}
                {!! Form::hidden('status', 'active'); !!}

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('healthsystem/users/', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add System Administrator', ['class' => 'btn btn-success pull-right'] ) !!}
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
