@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Add Finding')
@section('page_description','')



@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    <p>{{$eop->text}}</p>
</div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Populate Finding Attributes</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'system-admin/accreditation/eop/status/'.$eop->id.'/finding/add', 'class' => 'form-horizontal']) !!}
            <fieldset>
            <!-- Status -->
                <div class="form-group">
                    {!! Form::label('status', 'Status:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('status', ['initial' => 'Initial Submission','non-compliant' => 'Non-Compliant','pending_verification' => 'Pending Verification','compliant' => 'Compliant'], Request::old('status'), ['class' => 'form-control']) !!}
                    </div>
                </div>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('description', 'Finding Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('description', Request::old('description'), ['class' => 'form-control', 'placeholder' => 'description','rows' => 3]) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('location', 'Location:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('location', Request::old('location'), ['class' => 'form-control', 'placeholder' => 'location','rows' => 3]) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('plan_of_action', 'Plan of Action:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('plan_of_action', Request::old('plan_of_action'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('measure_of_success', 'Measure of Success:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('measure_of_success', Request::old('measure_of_success'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('measure_of_success_date', 'Measure of Success Date:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('measure_of_success_date', Request::old('measure_of_success_date'), ['class' => 'form-control date','id' => 'measure_of_success_date']) !!}
                  </div>
              </div>


              <div class="form-group">
                  {!! Form::label('internal_notes', 'Internal Notes:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('internal_notes', Request::old('internal_notes'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('attachments_path', 'Attach Documents:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                  {!! HTML::dropzone('attachments_path','accreditation/'.session('accreditation_id').'/building/'.session('building_id').'/eop/'.$eop->id.'/finding/'.strtotime('now'),'false') !!}
                  </div>
              </div>

            <div class="form-group">
                  {!! Form::label('documents_description', 'Documents Description:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('documents_description', Request::old('documents_description'), ['class' => 'form-control','rows' => 3]) !!}
                  </div>
              </div>


              {!! Form::hidden('eop_id', $eop->id) !!}
              {!! Form::hidden('building_id', session('building_id')) !!}
              {!! Form::hidden('healthsystem_id', Auth::guard('system_user')->user()->healthsystem_id) !!}

              {!! Form::hidden('created_by_user_id',Auth::guard('system_user')->user()->id) !!}

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('system-admin/accreditation/eop/status/'.$eop->id,'Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Add Finding', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>

            {!! Form::close()  !!}
        </div>

   <script>
    $(".date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
  </script>



@endsection