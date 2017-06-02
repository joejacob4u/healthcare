@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Elements of Performance')
@section('page_description','Add elements of performance here')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Elements of Performance for {{$standard_label->label}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/standard-label/'.$standard_label->id.'/eop/add', 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'EP Number:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', Request::old('name'), ['class' => 'form-control', 'placeholder' => 'eg like EC 01.01.01 - ep1']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('text', 'Text:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('text', Request::old('text'), ['class' => 'form-control']) !!}
                  </div>
              </div>

                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('documentation', 'Documentation Required:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('documentation', ['0' => 'No','1' => 'Yes'], Request::old('documentation'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    {!! Form::label('frequency', 'Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('frequency', ['daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly','quarterly' => 'Quarterly','annually' => 'Annually','semi-annually' => 'Semi-anually', 'two-years' => 'Two Years', 'three-years' => 'Three Years', 'four-years' => 'Four Years', 'five-years' => 'Five Years', 'six-years' => 'Six Years'], Request::old('frequency'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('risk', 'Risk:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('risk', ['0' => 'No','1' => 'Yes'], Request::old('risk'), ['class' => 'form-control']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('cops', 'CMS COPS:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('cops[]', $cops, Request::old('cops'), ['class' => 'form-control selectpicker','multiple' => 'true']) !!}
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/standard-label/'.$standard_label->id.'/eop','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Add EOP', ['class' => 'btn btn-success pull-right'] ) !!}
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
