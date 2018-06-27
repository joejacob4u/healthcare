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
                        Baseline date N/A - {{ $eop->getDocumentBaseLineDate(session('building_id'))->comment }}@if(Auth::user()->isAdmin())<a data-toggle="modal" data-target="#baselineDateModal" href="#" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Baseline Date</a>@endif
                    @else
                        Baseline Date : {{ \Carbon\Carbon::parse($eop->getDocumentBaseLineDate(session('building_id'))->baseline_date)->toFormattedDateString() }} @if(Auth::user()->isAdmin())<a data-toggle="modal" data-target="#baselineDateModal" href="#" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Baseline Date</a>@endif
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
            @if(!empty($eop->getDocumentBaseLineDate(session('building_id'))))
                @if($eop->getDocumentBaseLineDate(session('building_id'))->is_baseline_disabled)
                    Upcoming Upload Date Unavailable
                @elseif($eop->getNextDocumentUploadDate(session('building_id')) == 'cannot_find_date')
                    Next date is per policy / per needed <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('any-date')"><span class="glyphicon glyphicon glyphicon-circle-arrow-right"></span> Start Submission</button>
                @elseif($eop->getNextDocumentUploadDate(session('building_id')) != 'cannot_find_date' && !empty($eop->getNextDocumentUploadDate(session('building_id')))) 
                    {{ \Carbon\Carbon::parse($eop->getNextDocumentUploadDate(session('building_id')))->toFormattedDateString() }} <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('{{$eop->getNextDocumentUploadDate(session('building_id'))}}')"><span class="glyphicon glyphicon-circle-arrow-right"></span> Start Submission</button>
                @elseif($eop->frequency == 'per_needed' || $eop->frequency == 'as_needed')
                    Next date is per policy / per needed <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('any-date')"><span class="glyphicon glyphicon glyphicon-circle-arrow-right"></span> Start Submission</button>
                @else 
                    Please set baseline date 
                @endif
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
                        <li class="list-group-item">{{ date('F j, Y',strtotime($date))}} <button class="btn btn-primary btn-xs pull-right" onclick="startSubmission('{{$date}}')"><span class="glyphicon glyphicon-circle-arrow-right"></span> Start Submission</button></li>
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
        <h4>Document Submitted Dates</h4>
      </div>
      <div class="box-body">
            <table id="documents_table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Required Submission Date</th>
                        <th>Submitted By</th>
                        <th>Status</th>
                        <th>Remove</th>
                        <th>Activity</th>
                        <th>Add Finding</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Required Submission Date</th>
                        <th>Submitted By</th>
                        <th>Status</th>
                        <th>Remove</th>
                        <th>Activity</th>
                        <th>Add Finding</th>
                    </tr>
                </tfoot>
                <tbody>
                
                  @foreach($submission_dates as $submission_date)
                    <tr id="tr-{{$submission_date->id}}">
                        <td>{{$submission_date->submission_date->toFormattedDateString() }}</td>
                        <td>{{ App\User::find($submission_date->user_id)->name }}</td>
                        <td>{{ $submission_date->status}}</td>
                        <td>{!! link_to('#','Remove',['class' => 'btn-xs btn-danger','onclick' => "removeSubmissionDate('$submission_date->id')"]) !!}</td>
                        <td>{!! link_to('system-admin/accreditation/eop/'.$eop->id.'/submission_date/'.$submission_date->id.'/documents','View Activity',['class' => 'btn-xs btn-primary']) !!}</td>
                        @if($submission_date->status == 'non-compliant')
                                <td>{!! link_to('system-admin/accreditation/eop/status/'.$eop->id.'/finding/add?document_id='.$submission_date->documents->last()->id,'Add Finding',['class' => 'btn-xs btn-warning']) !!}</td>
                            @endif
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
                  {!! Form::hidden('accreditation_id',session('accreditation_id')) !!}
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

<!-- Start Submission Modal -->
  <div class="modal fade" id="startSubmissionModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Documents</h4>
        </div>
        <div class="modal-body">
          <p id="submission_date_verbiage"></p>
          
          {!! Form::open(['url' => 'system-admin/accreditation/eop/'.$eop->id.'/submission_date']) !!}
            {!! Form::hidden('submission_date','',['id' => 'submission_date']) !!}
            {!! Form::hidden('building_id',session('building_id')) !!}
            {!! Form::hidden('status','initial') !!}
            {!! Form::hidden('eop_id',$eop->id) !!}
            {!! Form::hidden('accreditation_id',session('accreditation_id')) !!}
            {!! Form::hidden('user_id',Auth::user()->id) !!}
            <button type="submit" class="btn btn-primary" id="submit_btn">Start Submission</button>
          {!! Form::close()  !!}
      </div>
      <div class="modal-footer">
        After initiating a submission date, you can upload documents to this date on the next step.
      </div>
    </div>
  </div>
  <!--Start Submission Modal -->

<script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>


<script>


    $("#baseline_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });

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

function startSubmission(date)
{
    if(date == 'anydate')
    {

    }
    else
    {
        $('#submission_date_verbiage').text('Do you want to start submission for '+date+' ?');
        $('#submission_date').val(date);
        $('#startSubmissionModal').modal('show');
    }
}

function removeSubmissionDate(id)
{
    bootbox.confirm("Do you really want to delete?", function(result)
    {
        if(result)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('system-admin/accreditation/eop/'.$eop->id.'/submission_date/delete') }}',
                data: { '_token' : '{{ csrf_token() }}','id' : id },
                beforeSend:function()
                {
                    
                },
                success:function(data)
                {
                    if(data)
                    {
                        $('#tr-'+id).remove();
                    }
                    
                },
                error:function(data)
                {

                },
                complete: function(data)
                {
                    $('.overlay').remove();
                }
            });
        }
    });

}

</script>

@endsection