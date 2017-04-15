@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in SubCOP Info for {{$cop->label}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/cop/'.$cop->id.'/subcop/add', 'class' => 'form-horizontal']) !!}

            <fieldset>


              <div class="form-group">
                  {!! Form::label('label', 'Section Label:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('label', $value = null, ['class' => 'form-control', 'placeholder' => 'Section Label']) !!}
                  </div>
              </div>

                <div class="form-group">
                    {!! Form::label('title', 'Section Title:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('title', $value = null, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('compliant', 'Compliant:',['class' => 'col-lg-2 control-label'] )  !!}
                    <div class="col-lg-10">
                        {!!  Form::select('compliant', [0 => 'Not Applicable',1 => 'Applicable'], $selected = null, ['class' => 'form-control selectpicker']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {{ link_to('admin/cop/'.$cop->id.'/subcop', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
                        {!! Form::submit('Add SubCOP', ['class' => 'btn btn-success pull-right'] ) !!}
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
