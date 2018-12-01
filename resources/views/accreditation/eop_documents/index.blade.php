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

@php
$accreditation_requirement_id = (!$submission_dates->isEmpty()) ? $submission_dates->first()->accreditation_requirement_id : session('accreditation_requirement_id');

@endphp

<ol class="breadcrumb">
    <li><a href="{{url('accreditation/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="/system-admin/accreditation/{{ $eop->standardLabel->accreditation_id }}/accreditation_requirement/<?php echo $accreditation_requirement_id; ?>"> Accreditation Requirement</a></li>
    <li class="active">Documentation</li>
</ol>

@if(count($equipments) < 1)



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
                @if(!empty($eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)))
                    @if($eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)->is_baseline_disabled)
                        Baseline date N/A - {{ $eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)->comment }}@if(Auth::user()->isAdmin())<a data-toggle="modal" data-target="#baselineDateModal" href="#" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Baseline Date</a>@endif
                    @else
                        Baseline Date : {{ \Carbon\Carbon::parse($eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)->baseline_date)->toFormattedDateString() }} @if(Auth::user()->isAdmin())<a data-toggle="modal" data-target="#baselineDateModal" href="#" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Baseline Date</a>@endif
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
            @if(!empty($eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)))
                @if($eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)->is_baseline_disabled)
                    Upcoming Upload Date Unavailable
                @elseif($eop->getNextDocumentUploadDate($accreditation_requirement_id) == 'cannot_find_date')
                    Next date is per policy / per needed <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('any-date')"><span class="glyphicon glyphicon glyphicon-circle-arrow-right"></span> Start Submission</button>
                @elseif($eop->getNextDocumentUploadDate($accreditation_requirement_id) != 'cannot_find_date' && !empty($eop->getNextDocumentUploadDate(session('building_id')))) 
                    {{ \Carbon\Carbon::parse($eop->getNextDocumentUploadDate($accreditation_requirement_id))->toFormattedDateString() }} <button class="btn btn-primary btn-xs pull-right" onclick="uploadDocumentFiles('{{$eop->getNextDocumentUploadDate(session('building_id'),$accreditation_requirement_id)}}')"><span class="glyphicon glyphicon-circle-arrow-right"></span> Start Submission</button>
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

@if(!empty($eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)) && !$eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)->is_baseline_disabled)

@if(!empty($eop->calculateDocumentDates($eop->getDocumentBaseLineDate(session('building_id'),$accreditation_requirement_id)->baseline_date)))


@endif
@endif

    <div class="box">
      <div class="box-header with-border">
        <h4>Document Submitted Dates</h4>
      </div>
      <div class="box-body">
            <table id="documents_table" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Required Submission Date</th>
                        <th>Submitted By</th>
                        <th>Status</th>
                        <th>Activity</th>
                        <th>Add Finding</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Required Submission Date</th>
                        <th>Submitted By</th>
                        <th>Status</th>
                        <th>Activity</th>
                        <th>Add Finding</th>
                    </tr>
                </tfoot>
                <tbody>
                
                  @foreach($submission_dates as $submission_date)
                    <tr id="tr-{{$submission_date->id}}">
                        <td><span>{{$submission_date->submission_date}}</span>{{$submission_date->submission_date->toFormattedDateString() }}</td>
                        @if($submission_date->user_id != 0 )
                            <td>{{ App\User::find($submission_date->user_id)->name }}</td>
                            @else
                            <td>Action Required</td>
                        @endif
                        <td>{{ $submission_date->status}}</td>
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
                  {!! Form::hidden('accreditation_requirement_id', $accreditation_requirement_id,['id' => 'accreditation_requirement_id']) !!}

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

    <!-- Accreditation Requirement Modal -->


  <div class="modal fade" id="accreditation_requirement_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose your Accreditation Requirement</h4>
        </div>
        <div class="modal-body">
            <p class="bg-danger">You will need to set accreditation requirement first. You can set the baseline date after its set.</p>
                      <div class="form-group">
                {!! Form::label('accreditation_requirement_id', 'Accreditation Requirement:', ['class' => 'control-label']) !!}
                {!! Form::select('accreditation_requirement_id', $accreditation_requirements ,Request::old('accreditation_requirement_id'), ['class' => 'form-control','id' => 'accreditation_requirement_id']) !!}
            </div>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="set-btn">Set</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


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
            {!! Form::hidden('status','pending_upload') !!}
            {!! Form::hidden('eop_id',$eop->id) !!}
            {!! Form::hidden('accreditation_id',session('accreditation_id')) !!}
            {!! Form::hidden('accreditation_requirement_id', session('accreditation_requirement_id')) !!}
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

    $(document).ready(function() {
        $('#documents_table').DataTable( {
            "order": [[ 0, "desc" ]]
        } );
    } );


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
            $('#submission_date_verbiage').text('Do you want to start submission for '+moment(date).format('MMMM Do YYYY')+' ?');
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

$("#baselineDateModal").on('shown.bs.modal', function () {
    if($('#baselineDateModal #accreditation_requirement_id').val() == ''){
                $('#baselineDateModal').modal('hide');
        $('#accreditation_requirement_modal').modal('show');

    }
});

$('#set-btn').click(function(){

    var accreditation_requirement_id = $('#accreditation_requirement_modal #accreditation_requirement_id').val();

    $.ajax({
        type: 'POST',
        url: '{{ url('accreditation-requirement/set') }}',
        data: { '_token' : '{{ csrf_token() }}','accreditation_requirement_id' : accreditation_requirement_id },
        beforeSend:function()
        {
            
        },
        success:function(data)
        {
            location.reload();
        },
        error:function(data)
        {

        },
        complete: function(data)
        {
        }
    });

    
});


</script>

<style>

#documents_table td span {
    display:none; 
}

</style>

@else

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Document Submitted Dates - <strong>(Equipment Detected for EOP)</strong></h3>

        <div class="box-tools pull-right">
          <div class="pull-left"><a href="{{url('equipment/download')}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span> Download</a></div>
        </div>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Frequency</th>
                        <th>Date Required</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Frequency</th>
                        <th>Date Required</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                @foreach($equipments as $equipment)
                                  
                  @foreach($equipment->workOrders->where('building_id', session('building_id'))->where('equipment_id',$equipment->id) as $work_order)
                    <tr>
                      <td>{{$work_order->name}}</td>
                      <td>{{$work_order->equipment->category->name}}</td>
                      <td>{{$work_order->equipment->assetCategory->name}}</td>
                      <td>{{$work_order->equipment->description}}</td>
                      <td>{{$work_order->equipment->frequency}}</td>
                      <td>{{$work_order->work_order_date->toFormattedDateString()}}</td>
                      @if($work_order->user_id == 0)
                        <td>N/A</td> 
                      @else
                        <td>{{$work_order->user->name}}</td>
                      @endif 

                      <td>{{$work_order->status}}</td>

                        <td>{{link_to('equipment/pm/work-orders','Go to Work Order', ['class' => 'btn-xs btn btn-info'] )}}</td>

                    
                    </tr>

                    @endforeach
                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>


  <script>
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover(); 

      $('table').DataTable( {
        "order": [[ 5, "desc" ],[6,"desc"]]
    } );
  });
  </script>




@endif

@endsection