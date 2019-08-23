@extends('layouts.app')

@section('head')
@parent

@endsection

@section('page_title','Upload Documents')
@section('page_description','')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')


<ol class="breadcrumb">
    <li><a href="{{url('accreditation/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="/system-admin/accreditation/{{$submission_date->eop->standardLabel->accreditation_id}}/accreditation_requirement/<?php echo session('accreditation_requirement_id'); ?>"> Accreditation Requirement</a></li>
    <li><a href="/system-admin/accreditation/eop/{{$submission_date->eop->id}}/submission_date/{{$submission_date->id}}/documents"> {{\Carbon\Carbon::parse($submission_date->submission_date)->toFormattedDateString()}}</a></li>
    <li class="active">New Upload</li>
</ol>

<div class="callout callout-warning">
    <h4>Uploading for Submission Date : {{\Carbon\Carbon::parse($submission_date->submission_date)->toFormattedDateString()}}</h4>
</div>




    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Upload Documents</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'system-admin/accreditation/eop/submission_date/documents']) !!}
            <div class="form-group">
                {!! Form::label('document_date', 'Document Date:', ['class' => 'control-label']) !!}
                {!! Form::text('document_date',  Request::old('document_date'), ['class' => 'form-control','id' => 'document_date']); !!}
                <span class="help-block">Dates outside this range : {{\Carbon\Carbon::parse($tolerance_dates['start'])->toFormattedDateString()}} to {{\Carbon\Carbon::parse($tolerance_dates['end'])->toFormattedDateString()}} are considered non-compliant</span>
            </div>
            <div class="form-group">
                {!! Form::label('upload_date', 'Submission On:', ['class' => 'control-label']) !!}
                {!! Form::text('upload_date',  Request::old('upload_date'), ['class' => 'form-control','id' => 'upload_date']); !!}
            </div>
            <div class="form-group">
                {!! HTML::dropzone('document_path','accreditation/'.session('accreditation_id').'/building/'.session('building_id').'/eop/'.$submission_date->eop->id.'/'.strtotime('now'),'false','true') !!}
            </div>

            {!! Form::hidden('eop_document_submission_date_id',$submission_date->id) !!}
            {!! Form::hidden('status','pending_verification') !!}

              <button type="submit" class="btn btn-primary" id="submit_btn">Upload</button>
          {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>

    <script>

    $("#document_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
    });

    $('#upload_date').val(moment().format('YYYY-MM-DD HH:mm:ss'));
        $('#upload_date').prop('readonly',true);

    </script>

@endsection
