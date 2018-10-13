@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Update Preventive Maintenance Work Order')
@section('page_description','')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
@include('layouts.partials.warning')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Update Work Order for <strong>{{$work_order->name}}</strong></h3>

        <div class="box-tools pull-right">
            <a href="{{url('equipment/pm/work-orders')}}" class="btn btn-warning"> Back</a>
        </div>
      </div>
      <div class="box-body">
                <div class="row">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-info">
                        <h4 class="list-group-item-heading">Equipment Info</h4>
                        <p class="list-group-item-text" id="equipment_info"><strong>Manufacturer</strong> : {{$work_order->equipment->manufacturer}}&emsp; <strong>Model</strong> : {{$work_order->equipment->model_number}}&emsp; <strong>Serial Number</strong> :  {{$work_order->equipment->serial_number}}&emsp; <strong>ID #</strong> :  {{$work_order->equipment->identification_number}}&emsp; <strong>Location (Room)</strong> :  {{$work_order->equipment->room->room_number}}</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-warning">
                        <h4 class="list-group-item-heading">Equipment Description</h4>
                        <p class="list-group-item-text" id="equipment_description">{{$work_order->equipment->description}}</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-danger">
                        <h4 class="list-group-item-heading">Preventive Maintenance Procedure</h4>
                        <p class="list-group-item-text" id="equipment_pm_procedure">{{$work_order->equipment->preventive_maintenance_procedure}}</p>
                    </a>
                </div>
             </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="well">
                    <form id="loginForm" method="POST" action="{{url('equipment/pm/work-orders/update/'.$work_order->id)}}" novalidate="novalidate">
                        <div class="form-group">
                            <label for="is_in_house_picker">Employment Type:</label>
                            {!! Form::select('is_in_house_picker', ['-1' => 'Please select',1 => 'In-House',0 => 'External'], $work_order->is_in_house, ['class' => 'form-control','id' => 'is_in_house_picker']); !!}
                            <span class="help-block">This field is required.</span>
                        </div>

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="pull-right">
                                    <button type="button" onclick="fireStatusModal()" class="btn btn-success btn-sm">Add Status</button>
                                </div>
                                <h5>Status History</h5>
                            </div>
                            <div class="panel-body">
                                @foreach($work_order->workOrderStatuses as $work_order_status)
                                    @if($work_order_status->id == '1')
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h4>{{$work_order_status->name}} : [{{ App\User::find($work_order_status->pivot->user_id)->name}}]</h4></div>
                                            <div class="panel-body">
                                                <strong>Job started at {{\Carbon\Carbon::parse($work_order->start_time)->format('F j, Y  h:i A')}}</strong><br>
                                                <strong>Job ended at {{\Carbon\Carbon::parse($work_order->end_time)->format('F j, Y  h:i A')}}</strong><br>
                                                
                                                @if(!empty($work_order_status->pivot->comment))
                                                    <br><br><blockquote>{{$work_order_status->pivot->comment}}</blockquote>
                                                @endif

                                                @if(!empty($work_order_status->pivot->attachment))
                                                    @php
                                                    $no_of_files = count(Storage::disk('s3')->files($work_order_status->pivot->attachment));
                                                    @endphp

                                                    @if($no_of_files > 0) 
                                                        <br><br>{!! HTML::dropzone('attachment_'.$work_order_status->id, $work_order_status->pivot->attachment,'true','false') !!}
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($work_order_status->id == '2')
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h4>{{$work_order_status->name}}</h4></div>
                                            <div class="panel-body">
                                            <strong>Job started at {{\Carbon\Carbon::parse($work_order->start_time)->format('F j, Y  h:i A')}}</strong>
                                            <br><br><strong>Job ended at {{\Carbon\Carbon::parse($work_order->end_time)->format('F j, Y  h:i A')}}</strong>
                                            @if(!empty($work_order_status->pivot->comment))
                                                <br><br><blockquote>{{$work_order_status->pivot->comment}}</blockquote>
                                            @endif
                                            @if(!empty($work_order_status->pivot->attachment))
                                                @php
                                                $no_of_files = count(Storage::disk('s3')->files($work_order_status->pivot->attachment));
                                                @endphp

                                                @if($no_of_files > 0) 
                                                   <br><br> {!! HTML::dropzone('attachment_'.$work_order_status->id, $work_order_status->pivot->attachment,'true','false') !!}
                                                @endif
                                            @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if($work_order_status->id == '3')
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h4>{{$work_order_status->name}}</h4></div>
                                            <div class="panel-body">
                                            <strong>Job started at {{\Carbon\Carbon::parse($work_order->start_time)->format('F j, Y  h:i A')}}</strong>
                                            <br><br><strong>Job ended at {{\Carbon\Carbon::parse($work_order->end_time)->format('F j, Y  h:i A')}}</strong>
                                            @if(!empty($work_order_status->pivot->comment))
                                                <br><br><blockquote>{{$work_order_status->pivot->comment}}</blockquote>
                                            @endif
                                            @if(!empty($work_order_status->pivot->attachment))
                                                @php
                                                $no_of_files = count(Storage::disk('s3')->files($work_order_status->pivot->attachment));
                                                @endphp

                                                @if($no_of_files > 0) 
                                                   <br><br> {!! HTML::dropzone('attachment_'.$work_order_status->id, $work_order_status->pivot->attachment,'true','false') !!}
                                                @endif
                                            @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if($work_order_status->id == '4')
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h4>{{$work_order_status->name}}</h4></div>
                                            <div class="panel-body">
                                            <strong>Job started at {{\Carbon\Carbon::parse($work_order->start_time)->format('F j, Y  h:i A')}}</strong>
                                            <br><br><strong>Job ended at {{\Carbon\Carbon::parse($work_order->end_time)->format('F j, Y  h:i A')}}</strong>
                                            @if(!empty($work_order_status->pivot->comment))
                                                <br><br><blockquote>{{$work_order_status->pivot->comment}}</blockquote>
                                            @endif
                                            @if(!empty($work_order_status->pivot->attachment))
                                                @php
                                                $no_of_files = count(Storage::disk('s3')->files($work_order_status->pivot->attachment));
                                                @endphp

                                                @if($no_of_files > 0) 
                                                   <br><br> {!! HTML::dropzone('attachment_'.$work_order_status->id, $work_order_status->pivot->attachment,'true','false') !!}
                                                @endif
                                            @endif
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            </div>
                        </div>
                        <div id="in_house_div" @if($work_order->is_in_house == 1) style="" @else style="display:none;"  @endif>
                        </div>
                        
                        <a href="{{url('equipment/pm/work-orders')}}" class="btn btn-success btn-block">Save</a>
                        {{ csrf_field()}}
                    </form>
                </div>
            </div>
          </div>
        </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

    <!-- Status Modal -->
    <div id="statusModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Status</h4>
        </div>
        <div class="modal-body">
            <div class="well">
            {!! Form::open(['url' => 'equipment/work-orders/status', 'class' => 'form-horizontal']) !!}
                
                <div class="form-group">
                    {!! Form::label('status', 'Status', ['class' => 'col-lg-2 control-label'] )  !!}
                    <div class="col-lg-10">
                        {!!  Form::select('status', $work_order_statuses->prepend('Please Select',0)->toArray(), '0', ['class' => 'form-control','id' => 'status']) !!}
                        <span class="help-block">This is required. Fill this out first.</span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('start_time', 'Start Time:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('start_time', $value = null, ['class' => 'form-control', 'placeholder' => 'start time','id' => 'start_time']) !!}
                        <span class="help-block">Start Time is required.</span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('end_time', 'End Time:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('end_time', $value = null, ['class' => 'form-control', 'placeholder' => 'end time','id' => 'end_time']) !!}
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('comment', 'Comment', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::textarea('comment', $value = null, ['class' => 'form-control', 'rows' => 3,'id' => 'comment']) !!}
                        <span class="help-block">Comment on status.</span>
                    </div>
                </div>

                <input type='hidden' name='equipment_work_order_id' id="equipment_work_order_id" value="{{$work_order->id}}">

                <div class="form-group">
                    {!! Form::label('attachment', 'Attachment', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! HTML::dropzone('attachment','equipments/pm/work_order/'.$work_order->id.'/'.strtotime('now'),'true','true') !!}
                        <span class="help-block"></span>
                    </div>
                </div>

                <input type='hidden' name='user_id' id="user_id" value='{{Auth::user()->id}}'>
                <input type='hidden' name='is_in_house' id="is_in_house" value=''>
            
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add Status</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
        {!! Form::close()  !!}
    </div>
    </div>

    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>

    <script>



    function fireStatusModal()
    {
        if($('#is_in_house_picker').val() != -1)
        {
            if($('#is_in_house_picker').val() == 0){
               

                $("#start_time").flatpickr({
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        altFormat: "F j,Y",
                        altInput: true
                });



                $("#end_time").flatpickr({
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        altFormat: "F j,Y",
                        altInput: true
                });


                $('#comment').text('File Upload and Compliant');
                $('#status').val('4');
            }
            else if($('#is_in_house_picker').val() == 1){
                
                    $("#start_time").flatpickr({
                            enableTime: true,
                            dateFormat: "Y-m-d H:i:S",
                            altFormat: "F j,Y h:i K",
                            altInput: true
                    });


                    $("#end_time").flatpickr({
                            enableTime: true,
                            dateFormat: "Y-m-d H:i:S",
                            altFormat: "F j,Y h:i K",
                            altInput: true,
                    });
            }

            // var dropzone_id = moment().unix();
            // var dropzone_path = 'equipments/pm/work_order/'+dropzone_id;
            // $('#statusModal .dropzone').attr('id','dropzone_'+dropzone_id);
            // createDropZone('dropzone_'+dropzone_id,dropzone_path);
            $('#statusModal').modal('show');
            $('#is_in_house').val($('#is_in_house_picker').val());
        }
        else
        {
            alert('You must set employment type first.');
        }
    }

    $('#is_in_house_picker').change(function(){

        if($(this).val() == 0){
            
            $('#comment').text('File Upload and Compliant');
            $('#status').val('4');
            $('.dropzone').next().html( "Attachment is required.");
            $('#end_time').next().html( "End time is required.");
        }
        else{
            
        }

    });


    $("#end_time").focus(function(){
        
        if(!$("#start_time").val()){
            $('#start_time').focus();
            alert('You will need to set start time first.');

        }

    });

    $('#status').change(function(){

        if($(this).val() == 1)
        {
            $('#comment').next().html( "Comment is preferred but optional.");
            $('.dropzone').next().html( "Attachment is optional.");
        }
        else if($(this).val() == 2)
        {
            $('#comment').next().html( "Comment is required.");
            $('#comment').attr('placeholder','Please elaborate on parts on order.');
            $('.dropzone').next().html( "Attachment is optional.");
        }
        else if($(this).val() == 3)
        {
            $('#comment').next().html( "Comment is required.");
            $('#comment').attr('placeholder','Please elaborate why the status is a BCM.');
            $('.dropzone').next().html( "Attachment is optional.");
        }
        else if($(this).val() == 4)
        {
            $('#comment').next().html( "Comment is optional.");
            
            if($('#is_in_house').val() == 0)
            {
                $('.dropzone').next().html( "Attachment is required.");
            }
            else
            {
                $('.dropzone').next().html( "Attachment is optional.");
            }
            
        }

    });

    function createDropZone(dropzone_id,dropzone_path)
    {
        var s3url = '<?php echo env('S3_URL'); ?>';

        $('#attachment').val(dropzone_path);

        $('#'+dropzone_id).dropzone({ 
            url: '/dropzone/upload' ,
            paramName: 'file',
            maxFilesize: 4,
            autoDiscover: false,
            addRemoveLinks: true,
            init: function() {
                this.on('sending', function(file, xhr, formData){
                    formData.append('_token', $('meta[name=\"csrf-token\"]').attr('content'));
                    formData.append('folder', dropzone_path);
                    if (file.type.indexOf('image/') == -1)
                    {
                        //this.emit('thumbnail', file, '/images/document.png');
                    }

                });


                this.on('success', function(file, xhr){
                    console.log('file uploaded'+file);
                });
                this.on('removedfile', function(file) {
                    $.ajax({
                        type: 'POST',
                        url: '/dropzone/delete',
                        data: {file: file.name,directory:dropzone_path, _token: $('meta[name=\"csrf-token\"]').attr('content')},
                        dataType: 'html',
                        success: function(data){

                        }
                    });

                });
            },
        });
    }


    </script>



@endsection
