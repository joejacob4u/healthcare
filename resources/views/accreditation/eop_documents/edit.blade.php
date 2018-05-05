@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Document')
@section('page_description','')



@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="/system-admin/accreditation/<?php echo session('accreditation_id'); ?>/accreditation_requirement/<?php echo session('accreditation_requirement_id'); ?>"><i class="fa fa-dashboard"></i> Accreditation Requirement</a></li>
    <li><a href="/system-admin/accreditation/eop/<?php echo $document->eop_id; ?>/documents">Documents</a></li>
    <li class="active">Edit</li>
</ol>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Document</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'system-admin/accreditation/eop/document/edit/'.$document->id, 'class' => '']) !!}
            <div class="form-group">
                {!! Form::label('submission_date', 'Submission Date:', ['class' => 'control-label']) !!}
                {!! Form::text('submission_date',  $document->submission_date, ['class' => 'form-control','id' => 'submission_date','readonly' => true]); !!}
            </div>
            <div class="form-group">
                {!! Form::label('upload_date', 'Submission On:', ['class' => 'control-label']) !!}
                {!! Form::text('upload_date',  $document->upload_date, ['class' => 'form-control','id' => 'upload_date','readonly' => true]); !!}
            </div>
            <div class="form-group">
                {!! Form::label('document_date', 'Document Date:', ['class' => 'control-label']) !!}
                {!! Form::text('document_date', $document->document_date, ['class' => 'form-control','id' => 'document_date']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('document_path', 'Documents:', ['class' => 'control-label']) !!}
                {!! HTML::dropzone('document_path',$document->document_path,'true') !!}
            </div>

            {!! Form::hidden('building_id',session('building_id')) !!}
            {!! Form::hidden('eop_id',$document->eop_id) !!}
            {!! Form::hidden('user_id',$document->user_id) !!}

              <button type="submit" class="btn btn-primary" id="submit_btn">Edit</button>
            {!! Form::close()  !!}
        </div>

        <script>

        $("#document_date").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
            });

        </script>



@endsection