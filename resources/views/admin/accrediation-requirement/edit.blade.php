@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Accrediation Requirements')
@section('page_description','Fill in form below.')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Accreditation Requirement</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/accrediation-requirements/edit/'.$accrediation_requirement->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $accrediation_requirement->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                  </div>
              </div>
                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('accrediations', 'Accrediation:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('accrediations[]', $accrediations, $accrediation_requirement->accrediations->pluck('id')->toArray(), ['class' => 'form-control selectpicker','multiple' => 'true']); !!}
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! Form::button('Cancel', ['class' => 'btn btn-warning','href' => 'admin/accrediation-requirements'] ) !!}
                        {!! Form::submit('Save Accrediation Requirement', ['class' => 'btn btn-success pull-right'] ) !!}
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
