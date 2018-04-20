@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Findings for  - <strong>'.$building->name.'</strong>')
@section('page_description','<span class="label label-'.$finding->statusColor().'">'.$finding->status.'</span>')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="{{url('system-admin/accreditation/<?php echo session('accreditation_id'); ?>/accreditation_requirement/<?php echo session('accreditation_requirement_id'); ?>')}}"><i class="fa fa-dashboard"></i> Accreditation Requirement</a></li>
    <li><a href="{{url('system-admin/accreditation/eop/status/'.$finding->eop_id)}}">Status</a></li>
    <li class="active">Finding Activity</li>
</ol>

<div class="callout callout-info">
    <h4>Finding Description</h4>
    <p>{{$finding->description}}</p>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Finding Info</h3>

        <div class="box-tools pull-right">
        </button>
        </div>
    </div>
            <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                    <h3 class="box-title">Plan of Action</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                    {{$finding->plan_of_action}}
                    </div>
                <!-- /.box-body -->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                    <h3 class="box-title">Measure of Success </h3> 

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                    {{$finding->measure_of_success}}
                    </div>
                    <div class="box-footer">
                        <span class="label bg-red">Date : {{ date('F j, Y, g:i a',strtotime($finding->measure_of_success_date)) }} </span>
                    </div>
                <!-- /.box-body -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                    <h3 class="box-title">Internal Notes</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                    {{$finding->internal_notes}}
                    </div>
                <!-- /.box-body -->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                    <h3 class="box-title">Location</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                    {{$finding->location}}
                    </div>
                <!-- /.box-body -->
                </div>
            </div>

        </div>

        <div class="row">
            <div class="box box-primary box-solid">
            <div class="box-header with-border">
            <h3 class="box-title">Files</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="list-group">
                    @foreach(\Illuminate\Support\Facades\Storage::disk('s3')->files($finding->attachments_path) as $file)
                        <li class="list-group-item">{{$file}} <a href="{{Storage::disk('s3')->url($file)}}" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-save"></span> Download</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="box-footer">
                {{$finding->documents_description}}
            </div> 
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Timeline</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#commentsModal"><i class="fa fa-plus"></i> Comment
                </button>
            </div>
            <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <ul class="timeline">
                        @foreach($finding->comments->sortByDesc('id') as $comment)
                            <li>
                                <i class="fa fa-comments bg-red"></i>
                                <div class="timeline-item">
                                    @if($comment->status != 'compliant')<span class="time"><i class="fa fa-clock-o"></i> {{ date('F j, Y, g:i a',strtotime($comment->created_at)) }}</span>@endif

                                    <h3 class="timeline-header"><strong>{{ App\User::find($comment->created_by_user_id)->name}}</strong> commented :</h3>

                                    <div class="timeline-body">
                                        <p>{{$comment->comment}} <span class="label label-{{$comment->statusColor()}}">{{$comment->status}}</span>@if($comment->assigned_user_id != 0)<span class="label label-primary">Assigned To:  {{App\User::find($comment->assigned_user_id)->name}} @endif</span>@if($comment->status != 'compliant')<span class="label label-warning">Due: {{ date("F j, Y, g:i a",strtotime($comment->due_date))}}</span>@endif</p>
                                        @if(!empty($comment->attachments_path))
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Attachments</div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    @foreach (\Illuminate\Support\Facades\Storage::disk('s3')->files($comment->attachments_path) as $filename)
                                                    <div class="col-sm-1"> 
                                                        @if(str_contains($filename,['.png','.jpeg','.jpg','.gif']))
                                                            <img class="img-thumbnail" src="{{Storage::disk('s3')->url($filename)}}" alt="" width="150" height="100">
                                                            <div class="caption">
                                                                <a href="{{Storage::disk('s3')->url($filename)}}" target="_blank">Download</a>
                                                            </div>
                                                        @else
                                                        <img class="img-thumbnail" src="/images/document.png" alt="" width="100" height="150">
                                                        <div class="caption">
                                                            <a href="{{Storage::disk('s3')->url($filename)}}" target="_blank">Download</a>
                                                        </div>
                                                        @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="timeline-footer">
                                        
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <li>
                            <i class="fa fa-bullhorn bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ date('F j, Y, g:i a',strtotime($finding->created_at)) }}</span>

                                <h3 class="timeline-header">Finding Reported</h3>

                                <div class="timeline-body">
                                    <strong>{{ App\User::find($finding->created_by_user_id)->name}}</strong> reported this finding.
                                </div>
                                <div class="timeline-footer">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        <!-- /.box-body -->
        </div>



    </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
</div>



<!-- Modal -->
<div class="modal fade" id="commentsModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Comment</h4>
        </div>
        <div class="modal-body">
            {!! Form::open(['url' => 'system-admin/accreditation/eop/status/'.$eop->id.'/finding/comment/add', 'class' => 'form-horizontal']) !!}
                <fieldset>
                <!-- Status -->
                    <div class="form-group">
                        {!! Form::label('status', 'Status:', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                            {!! Form::select('status', ['initial' => 'Initial Submission','non-compliant' => 'Non-Compliant (See Comments)','pending_verification' => 'Pending Verification','compliant' => 'Compliant','issues_corrected_verify' => 'Issues Corrected Please Verify Compliant'], $finding->status, ['class' => 'form-control','id' => 'status_picker']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('is_important', 'Flag as Important:', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                            {!! Form::select('is_important', ['0' => 'No','1' => 'Yes'], Request::old('is_important'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('comment', 'Comment:', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                            {!! Form::textarea('comment', Request::old('comment'), ['class' => 'form-control', 'placeholder' => 'comment','rows' => 3,'id' => 'comment']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('attachments_path', 'Attachments (Optional)', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                        {!! HTML::dropzone('attachments_path','accreditation/'.session('accreditation_id').'/building/'.$building->id.'/eop/'.$eop->id.'/finding/'.$finding->id.'/'.strtotime('now'),'false') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('assigned_user_id', 'Assign To:', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                            {!! Form::select('assigned_user_id', $healthsystem_users, Request::old('assigned_user_id'), ['id' => 'assigned_user_id','class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('due_date', 'Due Date:', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                            {!! Form::text('due_date', '', Request::old('due_date'), ['class' => 'form-control','id' => 'due_date']) !!}
                        </div>
                    </div>

                    {!! Form::hidden('created_by_user_id',Auth::guard('system_user')->user()->id) !!}
                    {!! Form::hidden('eop_finding_id',$finding->id) !!}
            </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add Comment</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {!! Form::close()  !!}

        </div>
      </div>
    </div>
  </div>

  <script>
    $("#due_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    $('#status_picker').change(function(){
        if($(this).val() == 'compliant')
        {
            $('#assigned_user_id').prop('disabled',true);
            $('#due_date').prop('disabled',true);
            $('#comment').val('This is now compliant.');
        }
        else
        {
            $('#assigned_user_id').prop('disabled',false);
            $('#due_date').prop('disabled',false);
            $('#comment').val('');
        }
    });
  </script>

@endsection