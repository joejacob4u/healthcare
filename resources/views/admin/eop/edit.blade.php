@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Elements of Performance')
@section('page_description','Edit elements of performance here')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Elements of Performance for {{$standard_label->label}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/standard-label/'.$standard_label->id.'/eop/edit/'.$eop->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $eop->name, ['class' => 'form-control', 'placeholder' => 'Client Name']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('text', 'Text:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('text', $eop->text, ['class' => 'form-control']) !!}
                  </div>
              </div>

                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('documentation', 'Documentation Required:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('documentation', ['0' => 'No','1' => 'Yes'], $eop->documentation, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    {!! Form::label('frequency', 'Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('frequency', ['no_frequency' => 'No Frequency','daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly','quarterly' => 'Quarterly','annually' => 'Annually','semi-annually' => 'Semi-anually', 'two-years' => 'Two Years', 'three-years' => 'Three Years', 'four-years' => 'Four Years', 'five-years' => 'Five Years', 'six-years' => 'Six Years'], $eop->frequency, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('risk', 'Risk:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('risk', ['0' => 'No','1' => 'Yes'], $eop->risk, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('cops', 'CMS COPS:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('cops[]', $cops, $eop->subCOPs->pluck('id')->toArray(), ['class' => 'form-control selectpicker','multiple' => 'true']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('accreditation', 'Accreditation:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('accreditation', $eop->standardLabel->accreditation->name, ['class' => 'form-control', 'disabled' => true]) !!}
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/standard-label/'.$standard_label->id.'/eop','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Save EOP', ['class' => 'btn btn-success pull-right'] ) !!}
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
