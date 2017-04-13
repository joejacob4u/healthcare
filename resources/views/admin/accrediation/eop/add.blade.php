@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Add Elements of Performance for {{$accr_requirement->label}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/accreditation/eop/add/'.$accr_requirement->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('elements_of_performance', 'Element of Performance:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('elements_of_performance', $value = null, ['class' => 'form-control', 'placeholder' => 'Element of Performance']) !!}
                  </div>
              </div>
                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('documentation', 'Documentation:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!!  Form::select('documentation', ['0' => 'No','1' => 'Yes'], $selected = null, ['class' => 'form-control selectpicker']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('frequency', 'Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!!  Form::select('frequency', ['daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly'], $selected = null, ['class' => 'form-control selectpicker']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('risk', 'Risk:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!!  Form::select('risk', ['0' => 'No','1' => 'Yes'], $selected = null, ['class' => 'form-control selectpicker']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('risk_assessment', 'Risk Assessment:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!!  Form::select('risk_assessment', ['0' => 'No','1' => 'Yes'], $selected = null, ['class' => 'form-control selectpicker']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('references', 'References:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!!  Form::select('references[]', $eops, $selected = null, ['class' => 'form-control selectpicker','multiple' => 'true']) !!}
                    </div>
                </div>



                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/accreditation/eop/'.$accr_requirement->id, $title = 'Back', $attributes = ['class' => 'btn btn-warning'], $secure = null)!!}
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
