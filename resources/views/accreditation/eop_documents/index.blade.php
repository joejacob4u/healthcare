@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','EOP Documentation - <strong>'.session('building_name').'</strong>')
@section('page_description','Configure EOP Documentations here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')


<ol class="breadcrumb">
    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="/system-admin/accreditation/<?php echo session('accreditation_id'); ?>/accreditation_requirement/<?php echo session('accreditation_requirement_id'); ?>"> Accreditation Requirement</a></li>
    <li class="active">Documentation</li>
</ol>


<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    <p>{{$eop->text}}</p>
</div>



<div class="row">
    <div class="col-md-6">
        <div class="callout callout-warning">
            <h4>EOP Upload Frequency : {{ ucfirst($eop->frequency) }}</h4>
            @if($eop->frequency == 'per_needed' || $eop->frequency == 'as_needed')
                Please upload documents as per policy / per needed
            @else
            <p>        
                @if(!empty($eop->getDocumentBaseLineDate(session('building_id'))))
                    @if($eop->getDocumentBaseLineDate(session('building_id'))->is_baseline_disabled)
                        Baseline date N/A - {{ $eop->getDocumentBaseLineDate(session('building_id'))->comment }}<a data-toggle="modal" data-target="#baselineDateModal" href="#" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Baseline Date</a>
                    @else
                        Baseline Date : {{ $eop->getDocumentBaseLineDate(session('building_id'))->baseline_date }}<a data-toggle="modal" data-target="#baselineDateModal" href="#" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Baseline Date</a>
                    @endif
                @else
                    <a data-toggle="modal" data-target="#baselineDateModal" href="#" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-pencil"></span> Set Baseline Date to Start Uploading Documents</a>
                @endif   
            </p>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="callout callout-success">
            <h4>Upcoming Upload Date</h4>
            <p>
            @if($eop->getNextDocumentUploadDate(session('building_id')) == 'cannot_find_date')
                Next date is per policy / per needed <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('any-date')"><span class="glyphicon glyphicon-paperclip"></span> Upload Files</button>
            @elseif($eop->getNextDocumentUploadDate(session('building_id')) != 'cannot_find_date' && !empty($eop->getNextDocumentUploadDate(session('building_id')))) 
                {{ $eop->getNextDocumentUploadDate(session('building_id')) }} <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('{{$eop->getNextDocumentUploadDate(session('building_id'))}}')"><span class="glyphicon glyphicon-paperclip"></span> Upload Files</button>
            @elseif($eop->frequency == 'per_needed' || $eop->frequency == 'as_needed')
                Next date is per policy / per needed <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('any-date')"><span class="glyphicon glyphicon-paperclip"></span> Upload Files</button>
            @else 
                Please set baseline date 
            @endif
            </p>
        </div>
    </div>
</div>

@if(!empty($eop->getDocumentBaseLineDate(session('building_id'))) && !$eop->getDocumentBaseLineDate(session('building_id'))->is_baseline_disabled)

@if(!empty($eop->calculateDocumentDates($eop->getDocumentBaseLineDate(session('building_id'))->baseline_date)))

<div class="row">
    <div class="col-sm-12">
        <div class="box box-danger box-solid">
            <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-exclamation-triangle"></i> You have missing documents for some dates ({{ count($eop->calculateDocumentDates($eop->getDocumentBaseLineDate(session('building_id'))->baseline_date)) }})</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
                <ul class="list-group">
                    @foreach($eop->calculateDocumentDates($eop->getDocumentBaseLineDate(session('building_id'))->baseline_date) as $date)
                        <li class="list-group-item">{{ date('F j, Y',strtotime($date))}} <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('{{$date}}')"><span class="glyphicon glyphicon-paperclip"></span> Upload Files</button></li>
                    @endforeach
                </ul>
            </div>
        <!-- /.box-body -->
        </div>
    </div>
</div>

@endif
@endif

                

    <div class="box">
      <div class="box-header with-border">
      </div>
      <div class="box-body collapse" id="eop_form">

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>

    <div class="box">
      <div class="box-header with-border">
        <h4>EOP Document History</h4>
      </div>
      <div class="box-body">
                <table id="documents_table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Submit Date</th>
                        <th>Submitted On</th>
                        <th>Submitted By</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Submit Date</th>
                        <th>Submitted On</th>
                        <th>Submitted By</th>
                        <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                
                  @foreach($documents as $document)
                    <tr id="tr-{{$document->id}}">
                        <td>{{$document->submission_date}}</td>
                        <td>{{$document->upload_date}}</td>
                        <td>{{ App\User::find($document->user_id)->name}}</td>
                        <td>{!! link_to('system-admin/accreditation/eop/document/edit/'.$document->id,'Edit Files',['class' => 'btn-xs btn-primary']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>


      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>

    <!-- Baseline Date Modal -->
  <div class="modal fade" id="baselineDateModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Please select a baseline date</h4>
        </div>
        <div class="modal-body">
          {!! Form::open(['url' => 'system-admin/accreditation/eop/document/baseline-date']) !!}
            <fieldset>
            <!-- Status -->

              <!-- Name -->
              <div class="form-group">
                <div class="form-group">
                  <label class="checkbox-inline"><input type="checkbox" value="1" name="is_baseline_disabled" id="is_baseline_disabled">Not Applicable</label>
                </div>
                <div class="form-group" style="display:none" id="comment_div">
                    {!! Form::label('comment', 'Comment:', ['class' => 'control-label']) !!}
                    {!! Form::textarea('comment', Request::old('comment'), ['class' => 'form-control','id' => 'comment','placeholder' => 'Why is this N/A ?']) !!}
                </div>
                <div class="form-group" id="baseline_date_div">
                  {!! Form::label('baseline_date', 'Document Baseline Date:', ['class' => 'control-label']) !!}
                  {!! Form::text('baseline_date', Request::old('baseline_date'), ['class' => 'form-control','id' => 'baseline_date']) !!}
                </div>

                  {!! Form::hidden('building_id',session('building_id')) !!}
                  {!! Form::hidden('eop_id',$eop->id) !!}
                  
              </div>
            </fieldset>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close()  !!}
      </div>
    </div>
  </div>
  <!--End Baseline Date Modal -->

<!-- Upload Document Modal -->
  <div class="modal fade" id="uploadDocumentModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Documents</h4>
        </div>
        <div class="modal-body">
          {!! Form::open(['url' => 'system-admin/accreditation/eop/document/upload']) !!}
            <div class="form-group">
                {!! Form::label('submission_date', 'Submission Date:', ['class' => 'control-label']) !!}
                {!! Form::text('submission_date', '', Request::old('submission_date'), ['class' => 'form-control','id' => 'submission_date']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('document_date', 'Document Date:', ['class' => 'control-label']) !!}
                {!! Form::text('document_date', '', Request::old('document_date'), ['class' => 'form-control','id' => 'document_date']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('upload_date', 'Submission On:', ['class' => 'control-label']) !!}
                {!! Form::text('upload_date', '', Request::old('upload_date'), ['class' => 'form-control','id' => 'upload_date']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('document_path', 'Documents:', ['class' => 'control-label']) !!}
                {!! HTML::dropzone('document_path','accreditation/'.session('accreditation_id').'/building/'.session('building_id').'/eop/'.$eop->id.'/'.strtotime('now'),'false') !!}
            </div>

            {!! Form::hidden('building_id',session('building_id')) !!}
            {!! Form::hidden('eop_id',$eop->id) !!}
            {!! Form::hidden('user_id',Auth::guard('system_user')->user()->id) !!}

              <button type="submit" class="btn btn-primary" id="submit_btn">Upload</button>
          {!! Form::close()  !!}
      </div>
    </div>
  </div>
  <!--End Upload Document Modal -->


    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>
    <script>


    $("#baseline_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });

    function uploadDocumentFiles(date)
    {
        if(date == 'any-date')
        {
            $("#submission_date").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
            });
        }
        else
        {
            $('#submission_date').val(date);
            $('#submission_date').prop('readonly',true);

        }

        $("#document_date").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
            });

        $('#upload_date').val(moment().format('YYYY-MM-DD HH:mm:ss'));
        $('#upload_date').prop('readonly',true);
        $('#uploadDocumentModal').modal('show');

    }

    $("#is_baseline_disabled").change(function() {
        if(this.checked) {
            $('#comment_div').show();
            $('#baseline_date_div').hide();
            $('#baseline_date').val('0000-00-00');
        }
        else{
            $('#baseline_date_div').show();
            $('#comment_div').hide();
            $('#baseline_date').val('');
        }
    });

  </script>



@endsection
