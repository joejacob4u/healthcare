@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Accreditation Compliance Leader</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'workflows/accreditation-compliance-leaders/add', 'class' => 'form-horizontal']) !!}

            <fieldset>


              <div class="form-group">
                  {!! Form::label('name', 'Leader Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', Request::old('name'), ['class' => 'form-control', 'placeholder' => 'name']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('title', 'Title:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('title', Request::old('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'E-Mail:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('email', Request::old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('phone', 'Phone:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('phone', Request::old('phone'), ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                    </div>
                </div>




                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('workflows/accreditation-compliance-leaders', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add Accreditation Compliance Leader', ['class' => 'btn btn-success pull-right'] ) !!}
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
