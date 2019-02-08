@extends('layouts.app')

@section('head')
    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>

@parent

@endsection
@section('page_title','Demand Work Order')
@section('page_description','Created on '.$demand_work_order->created_at->toFormattedDateString())

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="{{url('equipment/work-orders')}}#demand-work-orders">Work Orders</a></li>
    <li>Demand Work Order {{$demand_work_order->identifier}}</li>
</ol>

<div class="callout callout-info">
    <h4>Demand Work Order for WO# : {{$demand_work_order->identifier}}</h4><br/>

    <div class="row">
        <div class="col-sm-6"><strong>Requester Name : </strong> {{$demand_work_order->requester_name}}</div>
        <div class="col-sm-6"><strong>Requester E-Mail : </strong> {{$demand_work_order->requester_email}}</div>
    </div><br/>

    <div class="row">
        <div class="col-sm-2"><strong>Comments</strong> </div>
        <div class="col-sm-10">{{$demand_work_order->comments}}</div>
    </div><br/>

    <div class="row">
        <div class="col-sm-4"><strong>Trade : </strong> {{$demand_work_order->trade->name}}</div>
        <div class="col-sm-4"><strong>Problem : </strong> {{$demand_work_order->problem->name}}</div>
        <div class="col-sm-4"><strong>Priority : </strong> {{$demand_work_order->priority->name}}</div>
    </div><br/>

    <div class="row">
        <div class="col-sm-6"><strong>Department : </strong> {{$demand_work_order->department->name}}</div>
        <div class="col-sm-6"><strong>Room : </strong> {{$demand_work_order->room->room_number}}</div>
    </div><br/>

</div>

@if(count($demand_work_order->problem->eops) > 0)

<div class="callout callout-info">
    <h4>EOP</h4>

    @foreach($demand_work_order->problem->eops as $eop)

    <a href="#" class="list-group-item active list-group-item-info">
        <h4>{{$eop->standardLabel->label}} - EOP : {{$eop->name}}</h4>
        <p>{{$eop->text}}</p>
    </a>

    @endforeach
</div>

@endif


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Status Timeline for WO# : {{$demand_work_order->identifier}}</h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-success" data-toggle="modal" onclick="openShift()"><span class="glyphicon glyphicon-plus"></span> Add Status</button>
        </div>
    </div>
    <div class="box-body">
        <ul class="timeline">
            @foreach($demand_work_order->shifts->sortByDesc('start_time') as $shift)
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    {{$shift->start_time->format('F j, Y g:i a')}} to {{$shift->end_time->format('F j, Y g:i a')}}
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-check-square-o bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{$shift->created_at->format('F j, Y g:i a')}}</span>

                <h3 class="timeline-header"><a href="#">{{$shift->user->name}}</a> marked this as <strong>{{$shift->status->name}}</strong></h3>

                <div class="timeline-body">
                    {{$shift->comment}}
                </div>
                <div class="timeline-footer">
                    {!! link_to('#','Delete',['class' => 'delete-btn btn-xs btn-danger','data-shift-id' => $shift->id]) !!}
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <!-- timeline item -->
            @php $files = Storage::disk('s3')->files($shift->attachment); @endphp
            @if(count($files) > 0)
            <li>
              <i class="fa fa-paperclip bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{$shift->created_at->format('F j, Y g:i a')}}</span>

                <h3 class="timeline-header"><a href="#">{{$shift->user->name}}</a> attached files</h3>

                <div class="timeline-body">
                    @foreach($files as $file)
                        @if(in_array(pathinfo(basename($file), PATHINFO_EXTENSION),['jpg','png','jpeg']))
                            <a href="{{config('filesystems.disks.s3.url').$file}}" target="_blank"><img width="150" height="100" src="{{config('filesystems.disks.s3.url').$file}}" alt="..." class="margin"></a>
                        @else
                            <a href="{{config('filesystems.disks.s3.url').$file}}" target="_blank"><img src="http://placehold.it/150x100&text={{basename($file)}}&fontsize=14&bold" alt="..." class="margin"></a>
                        @endif
                    @endforeach
                </div>
              </div>
            </li>
            @endif

            <!-- END timeline item -->
            <!-- timeline time label -->
            @endforeach
          </ul>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- /.box-footer-->
</div>


  <!-- Shift Modal -->
  <div class="modal fade" id="shift-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add a shift</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="usr">Start Time:</label>
            <input type="text" class="form-control" id="shift_start_time">
         </div>
         <div class="form-group">
            <label for="usr">End Time:</label>
            <input type="text" class="form-control" id="shift_end_time">
         </div>

        <div class="form-group">
            <label for="comment">Comment:</label>
            {!! Form::textarea('comment',  '', ['class' => 'form-control','id' => 'comment','rows' => 3]); !!}
         </div> 

        <div class="form-group">
            <label for="attachment">Attachment:</label>
            {!! HTML::dropzone('attachment','demand_work_orders/building/'.session('building_id').'/attachments/'.strtotime('now'),'false','true') !!}
         </div> 


        <div class="form-group">
            <label for="usr">Status:</label>
            {!! Form::select('equipment_work_order_status_id', $work_order_statuses->prepend('Please Select',0), '', ['class' => 'form-control selectpicker','id' => 'equipment_work_order_status_id','multiple' => false]); !!}
         </div>  

                   

        </div>
        <div class="modal-footer">
          <button type="button" onclick="saveShift()" class="btn btn-success">Add Shift</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--End of Shift Modal -->




  <script>

  var timeoutId;
  var user_id = '{{Auth::user()->id}}';

  $(document).ready(function(){
      
      $('[data-toggle="popover"]').popover(); 


    var start_time_picker = $("#shift_start_time").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
        altInput: true,
        altFormat: "M j, Y h:i K",
        onChange: function(selectedDates, dateStr, instance) {
            end_time_picker.setDate(dateStr)
        },

      });

    var end_time_picker = $("#shift_end_time").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
        altInput: true,
        altFormat: "M j, Y h:i K",
        onOpen: function(){
            if(!$("#shift_start_time").val())
            {
                alert('Start time has to be set first.');
            }
        },
        onClose: function(selectedDates, dateStr, instance) {
            
            if(moment(dateStr).isBefore($("#shift_start_time").val()))
            {
                end_time_picker.clear();
                alert('End time has to be a value earlier than start time.');
            }
        },

      });



      //save comment box



    });


    function openShift()
    {
        $('#shift-modal').modal('show');
    }

      function saveShift()
  {
      var shift_start_time = $('#shift_start_time').val();
      var shift_end_time = $('#shift_end_time').val();
      var attachment = $('input[name=attachment]').val()
      var comment = $('#comment').val();
      var equipment_work_order_status_id = $('#equipment_work_order_status_id').val();

      if(shift_start_time && shift_end_time && equipment_work_order_status_id != 0)
      {
            $.ajax({
                type: 'POST',
                url: '{{ url("equipment/demand-work-orders/".$demand_work_order->id."/shift") }}',
                data: { '_token' : '{{ csrf_token() }}', 
                        'start_time' : shift_start_time, 
                        'end_time' : shift_end_time,
                        'user_id' : user_id,
                        'attachment' : attachment,
                        'comment' : comment,
                        'equipment_work_order_status_id' : equipment_work_order_status_id,

                    },
                
                beforeSend:function()
                {
                    dialog = bootbox.dialog({
                        message: '<p class="text-center">Saving</p>',
                        closeButton: false
                    });

                },
                
                success:function(data)
                {
                    if(data.status == 'success')
                    {
                        dialog.modal('hide');
                        $('#shift-modal').modal('hide');
                        location.reload(true);
                    }
                },

                complete:function()
                {
                    $('.overlay').remove();
                },

                error:function()
                {
                    // failed request; give feedback to user
                }
            });
      }


  }

  $('.delete-btn').click(function(){
      
      var shift_id = $(this).attr('data-shift-id');

      bootbox.confirm('Do you really want to delete?', function(result){
        
        if(result){
            $.ajax({
                type: 'POST',
                url: '{{ url("equipment/demand-work-orders/".$demand_work_order->id."/shift/delete") }}',
                data: { '_token' : '{{ csrf_token() }}', 'shift_id' : shift_id},
                
                beforeSend:function()
                {
                    dialog = bootbox.dialog({
                        message: '<p class="text-center">Deleting</p>',
                        closeButton: false
                    });

                },
                
                success:function(data)
                {
                    if(data.status == 'success')
                    {
                        dialog.modal('hide');
                        location.reload(true);
                    }
                },

                complete:function()
                {
                    $('.overlay').remove();
                },

                error:function()
                {
                    // failed request; give feedback to user
                }
            });

        } 
      });




  });



  </script>
@endsection
