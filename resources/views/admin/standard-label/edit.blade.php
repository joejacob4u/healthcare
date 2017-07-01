@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Standard Label')
@section('page_description','Fill in form below.')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add in Standard Label</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/standard-label/edit/'.$standard_label->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('label', 'Label:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('label', $standard_label->label, ['class' => 'form-control', 'placeholder' => 'label']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('text', 'Text:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('text', $standard_label->text, ['class' => 'form-control', 'placeholder' => 'Text']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('description', 'Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('description', $standard_label->description, ['class' => 'form-control', 'placeholder' => 'description']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('accreditation', 'Accreditation:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::select('accreditation_id', $accreditations, $standard_label->accreditation_id, ['class' => 'form-control selectpicker']); !!}
                  </div>
              </div>


                <div class="form-group">
                    {!! Form::label('accreditation_requirements', 'Accreditation Requirement:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('accreditation_requirements[]', $accreditation_requirements, $standard_label->accreditationRequirements->pluck('id')->toArray(), ['class' => 'form-control selectpicker','multiple' => 'true']); !!}
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/standard-label','Cancel',['class' => 'btn btn-warning']) !!}
                        {!! Form::submit('Save Standard Label', ['class' => 'btn btn-success pull-right'] ) !!}
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
