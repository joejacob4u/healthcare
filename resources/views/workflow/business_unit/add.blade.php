@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Business Unit</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'workflows/business-units/add', 'class' => 'form-horizontal']) !!}

            <fieldset>


              <div class="form-group">
                  {!! Form::label('business_unit_number', 'Business Unit Number:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('business_unit_number', Request::old('business_unit_number'), ['class' => 'form-control', 'placeholder' => 'business unit number']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('description', 'Description:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('description', Request::old('description'), ['class' => 'form-control', 'placeholder' => 'Description']) !!}
                    </div>
                </div>




                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('workflows/business-units', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Business Unit', ['class' => 'btn btn-success pull-right'] ) !!}
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
