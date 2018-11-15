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
    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="/system-admin/accreditation/<?php echo session('accreditation_id'); ?>/accreditation_requirement/<?php echo session('accreditation_requirement_id'); ?>"> Accreditation Requirement</a></li>
    <li><a href="/system-admin/accreditation/eop/{{$submission_date->eop->id}}/submission_date/{{$submission_date->id}}/documents"> {{\Carbon\Carbon::parse($submission_date->submission_date)->toFormattedDateString()}}</a></li>
    <li class="active">New Upload</li>
</ol>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Comments</h3>
    </div>
    <div class="box-body">
        <div class="list-group">
        @foreach($document->comments as $comment)
            <a href="#" class="list-group-item">
            <h4 class="list-group-item-heading">{{ $comment->comment }}</h4>
            <p class="list-group-item-text">{{ App\User::find($comment->commented_by_user_id)->name }} on {{ \Carbon\Carbon::parse($comment->created_at)->toDayDateTimeString() }}</p>
            </a>
        @endforeach
        </div>
    </div>
<!-- /.box-body -->
</div>




<div class="row">
    <div class="col-sm-6">
        <div class="callout callout-info">
            <h4>Current Status : {{$document->status}}</h4>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="callout callout-warning">
            <h4>Uploading for Submission Date : {{\Carbon\Carbon::parse($submission_date->submission_date)->toFormattedDateString()}}</h4>
        </div>
    </div>
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
                {!! Form::text('document_date',  $document->document_date, ['class' => 'form-control','id' => 'document_date','disabled' => true]); !!}
            </div>
            <div class="form-group">
                {!! Form::label('upload_date', 'Submission On:', ['class' => 'control-label']) !!}
                {!! Form::text('upload_date',  $document->upload_date, ['class' => 'form-control','id' => 'upload_date','disabled' => true]); !!}
            </div>
            <div class="form-group">
                {!! HTML::dropzone('document_path',$document->document_path,'true','true') !!}
            </div>

            {!! Form::hidden('eop_document_submission_date_id',$document->eop_document_submission_date_id) !!}

          {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">
        @if(Auth::user()->isVerifier())

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@if($document->status == 'initial') Pending Verification @else Update Status @endif</h3>
            </div>
            <div class="box-body">
                <button onclick="confirmCompliant()" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Documents are Compliant</button>
                <button onclick="confirmNonCompliant()" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Documents are Non-Compliant</button>
            </div>
        <!-- /.box-body -->
        </div>

        @endif


      </div>
      <!-- /.box-footer-->
    </div>

    <!-- Compliant Modal -->
    <div id="compliantModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm Compliant</h4>
            </div>
            <div class="modal-body">
                <p><strong>This will confirm the below documents are compliant.</strong></p>
                {!! Form::open(['url' => 'system-admin/accreditation/eop/document/verify']) !!}
                    <div class="form-group">
                        {!! Form::label('comment', 'Comment:', ['class' => 'control-label']) !!}
                        {!! Form::textarea('comment',  'This has been verified and is compliant. Great Work!', ['class' => 'form-control','id' => 'comment']); !!}
                    </div>
                
                {!! Form::hidden('eop_document_id',$document->id) !!}
                {!! Form::hidden('commented_by_user_id',Auth::user()->id) !!}
                {!! Form::hidden('status','compliant') !!}

                <button type="submit" class="btn btn-success" id="submit_btn">Mark as Compliant</button>
                {!! Form::close()  !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
    </div>
    <!-- End Compliant Modal -->

    <!-- Non-Compliant Modal -->
    <div id="nonCompliantModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mark as Non-Complaint</h4>
            </div>
            <div class="modal-body">
                <p><strong>This will mark the documents as non-complaint.</strong></p>
                {!! Form::open(['url' => 'system-admin/accreditation/eop/document/verify']) !!}
                    <div class="form-group">
                        {!! Form::label('comment', 'Comment:', ['class' => 'control-label']) !!}
                        {!! Form::textarea('comment',  '', ['class' => 'form-control','id' => 'comment','placeholder' => 'What went wrong?']); !!}
                    </div>
                
                {!! Form::hidden('status','non-compliant') !!}
                {!! Form::hidden('eop_document_id',$document->id) !!}
                {!! Form::hidden('commented_by_user_id',Auth::user()->id) !!}

                <button type="submit" class="btn btn-danger" id="submit_btn">Mark as Non-Compliant</button>
                {!! Form::close()  !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
    </div>
    <!-- End Compliant Modal -->


    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>


    <script>

    $("#document_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });

    $('#upload_date').val(moment().format('YYYY-MM-DD HH:mm:ss'));
    $('#upload_date').prop('readonly',true);

    function confirmCompliant()
    {
        $('#compliantModal').modal('show');
    }

    function confirmNonCompliant()
    {
        $('#nonCompliantModal').modal('show');
    }

    </script>

@endsection
