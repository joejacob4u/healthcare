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
    <li><a href="/system-admin/accreditation/eop/{{$submission_date->eop->id}}/submission_dates/"> Submission Dates</a></li>
    <li class="active">{{\Carbon\Carbon::parse($submission_date->submission_date)->toFormattedDateString()}}</li>
</ol>



<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    @if(!empty($tolerant_dates))
        <p>{{$eop->text}}</p>
    @endif
</div>

<div class="callout callout-warning">
    <h4>Submission Date : {{\Carbon\Carbon::parse($submission_date->submission_date)->toFormattedDateString()}}</h4>
    @if(!empty($tolerant_dates))
        <p>Make sure to upload between these date ranges : {{ \Carbon\Carbon::parse($tolerant_dates['start'])->toFormattedDateString()}} - {{\Carbon\Carbon::parse($tolerant_dates['end'])->toFormattedDateString()}}</p>
    @endif
</div>





    <div class="box">
      <div class="box-header with-border">
        <h4>Uploaded Documents</h4>
        <div class="box-tools pull-right">
            <a href="{{url('system-admin/accreditation/eop/'.$eop->id.'/submission_date/'.$submission_date->id.'/documents/create')}}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-arrow-up"></span> Upload Documents</a>
        </div>
      </div>
      <div class="box-body">
            <table id="documents_table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Document Date</th>
                        <th>Upload Date</th>
                        <th>Status</th>
                        <th>View/Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Document Date</th>
                        <th>Upload Date</th>
                        <th>Status</th>
                        <th>View/Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($submission_date->documents->sortByDesc('id') as $document)
                        <tr id="tr-{{$document->id}}">
                            <td>{{ \Carbon\Carbon::parse($document->document_date)->toFormattedDateString()}}</td>
                            <td>{{ \Carbon\Carbon::parse($document->upload_date)->toFormattedDateString()}} ({{ \Carbon\Carbon::parse($document->upload_date)->diffForHumans() }})</td>
                            <td>{{ $document->status }}</td>
                            <td>{!! link_to('system-admin/accreditation/eop/'.$submission_date->eop->id.'/submission_date/'.$submission_date->id.'/documents/'.$document->id.'/edit','View/Edit',['class' => 'btn-xs btn-primary']) !!}</td>
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




<script>


    $("#baseline_date").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });

function startSubmission(date)
{
    if(date == 'anydate')
    {

    }
    else
    {
        $('#submission_date_verbiage').text('Do you want to start submission for '+moment(date),format('MMMM Do YYYY')+' ?');
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