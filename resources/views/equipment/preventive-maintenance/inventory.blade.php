@extends('layouts.app')

@section('head')
    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>

@parent

@endsection
@section('page_title','Inventory')
@section('page_description','Inventory for Baseline Date ( '.$work_order->baselineDate->date->toFormattedDateString().' )')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<ol class="breadcrumb">
    <li><a href="{{url('equipment/pm/work-orders')}}">Work Orders</a></li>
    <li>Inventory for {{$work_order->name}}</li>
</ol>

<div class="callout callout-info">
    <h4>Equipment Info</h4><br/>

    <div class="row">
        <div class="col-sm-4"><strong>Equipment Name : </strong> {{$work_order->equipment->name}}</div>
        <div class="col-sm-4"><strong>Manufacturer : </strong> {{$work_order->equipment->manufacturer}}</div>
        <div class="col-sm-4"><strong>Model Number : </strong> {{$work_order->equipment->model_number}}</div>
    </div><br/>

    <div class="row">
        <div class="col-sm-2"><strong>Description</strong> </div>
        <div class="col-sm-10">{{$work_order->equipment->description}}</div>
    </div><br/>

    <div class="row">
        <div class="col-sm-4"><strong>Utilization : </strong> {{$work_order->equipment->utilization}} %</div>
        <div class="col-sm-4"><strong>Frequency : </strong> {{$work_order->equipment->frequency}}</div>
        <div class="col-sm-4"><strong>Asset Category : </strong> {{$work_order->equipment->assetCategory->name}}</div>
    </div><br/>

    <div class="row">
        <div class="col-sm-2"><strong>PM Procedure</strong> </div>
        <div class="col-sm-10">{{$work_order->equipment->preventive_maintenance_procedure}}</div>
    </div>
</div>

@if(count($work_order->equipment->assetCategory->eops) > 0)

<div class="callout callout-warning">
    <h4>EOP</h4>

    @foreach($work_order->equipment->assetCategory->eops as $eop)

    <a href="#" class="list-group-item  list-group-item-info active">
        <h4>{{$eop->standardLabel->label}} - EOP : {{$eop->name}}</h4>
        <p>{{$eop->text}}</p>
    </a>

    @endforeach
</div>


@endif


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Shifts</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-success" data-toggle="modal" data-target="#shift-modal"><span class="glyphicon glyphicon-plus"></span> Add Shift</button>
        </div>
    </div>
    <div class="box-body">
        <table id="example" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>User</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($work_order->shifts as $shift)
                    <tr>
                      <td>{{$shift->start_time->toDayDateTimeString()}}</td>
                      <td>{{$shift->end_time->toDayDateTimeString()}}</td>
                      <td>{{$shift->user->name}}</td>
                    </tr>

                  @endforeach
                </tbody>
            </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        Adding a shift will split time between 'Complete and Complaint' inventories below
    </div>
    <!-- /.box-footer-->
</div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Preventive Maintenance View for Equipments in <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Inventory</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Status</th>
                        <th>Inventory</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Comment</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($work_order->workOrderInventories as $work_order_inventory)
                    <tr>
                      <td class="col-md-2">{!! Form::select('inventory_'.$work_order_inventory->id, $work_order_statuses, $work_order_inventory->equipment_work_order_status_id, ['class' => 'form-control status','data-inventory-id' => $work_order_inventory->id,'data-field' => 'equipment_work_order_status_id']); !!} <small class="label pull-right bg-yellow"><i class="fa fa-clock-o"></i> {{$work_order_inventory->updated_at->toDayDateTimeString()}}</small></td>
                      <td class="col-md-2">{{$work_order_inventory->inventory->name}}<button data-inventory = "{{json_encode($work_order_inventory->inventory)}}" data-room="{{$work_order_inventory->inventory->room->room_number}}" class="btn btn-link btn-xs inventory-info"><span class="glyphicon glyphicon-info-sign"></span></button></td>
                      <td class="col-md-2">{!! Form::text('start_time_'.$work_order_inventory->id, $work_order_inventory->start_time, ['class' => 'form-control date','data-inventory-id' => $work_order_inventory->id,'data-field' => 'start_time']) !!}</td>
                      <td class="col-md-2">{!! Form::text('end_time_'.$work_order_inventory->id, $work_order_inventory->end_time, ['class' => 'form-control date','data-inventory-id' => $work_order_inventory->id ,'data-field' => 'end_time']) !!} @if($work_order_inventory->user_id != 0)<small class="label pull-right bg-blue"><i class="fa fa-user"></i> {{$work_order_inventory->user->name}}</small>@endif</td>
                      <td class="col-md-4">{!! Form::text('comment_'.$work_order_inventory->id, $work_order_inventory->comment, ['class' => 'form-control comment','data-inventory-id' => $work_order_inventory->id,'data-field' => 'comment']) !!}</td>
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

      <!-- Info Modal -->

  <div class="modal fade" id="inventory_info_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Inventory Info</h4>
        </div>
        <div class="modal-body">
          <div class="list-group">
            

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Serial Number</h4>
              <p class="list-group-item-text" id="serial_number"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Identification Number</h4>
              <p class="list-group-item-text" id="identification_number"></p>
            </a>
            
            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Installation Date</h4>
              <p class="list-group-item-text" id="installation_date"></p>
            </a>

            <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">Room Number</h4>
              <p class="list-group-item-text" id="room_number"></p>
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- End of Info Modal -->

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

  var work_order_id = '{{$work_order->id}}';
  var timeoutId;
  var user_id = '{{Auth::user()->id}}';

  $(document).ready(function(){
      
      $('[data-toggle="popover"]').popover(); 

      $(".date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
        altInput: true,
        altFormat: "M j, Y h:i K",
        onChange: function(selectedDates, dateStr, instance) {
            update_field(instance.element.dataset.inventoryId,instance.element.dataset.field,dateStr)
        },
      });

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

      $('.comment').keypress(function () {

        var inventory_id = $(this).attr('data-inventory-id');
        var field = $(this).attr('data-field');
        var value = $(this).val();

        // If a timer was already started, clear it.
        if (timeoutId) clearTimeout(timeoutId);

        // Set timer that will save comment when it fires.
        timeoutId = setTimeout(function () {
            update_field(inventory_id,field,value);
        }, 1500);
     });

     //status

     $('select').change(function(){

        var inventory_id = $(this).attr('data-inventory-id');
        var field = $(this).attr('data-field');
        var value = $(this).val();
        update_field(inventory_id,field,value);

     });

     //inventory info

     $('.inventory-info').click(function(){
        var inventory_data = JSON.parse($(this).attr('data-inventory'));
        $('#serial_number').html(inventory_data.serial_number);
        $('#identification_number').html(inventory_data.identification_number);
        $('#installation_date').html(inventory_data.installation_date);
        $('#room_number').html($(this).attr('data-room'));
        $('#inventory_info_modal').modal('show');
     });

     function update_field(inventory_id,field,value)
     {
        $.ajax({
            type: 'POST',
            url: '{{ url("equipment/pm/work-orders/".$work_order->id."/inventory/update") }}',
            data: { '_token' : '{{ csrf_token() }}', 'field' : field, 'value' : value, 'inventory_id' : inventory_id },
            
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

  function saveShift()
  {
      var shift_start_time = $('#shift_start_time').val();
      var shift_end_time = $('#shift_end_time').val();

      if(shift_start_time && shift_end_time)
      {
            $.ajax({
                type: 'POST',
                url: '{{ url("equipment/pm/work-orders/".$work_order->id."/shift/add") }}',
                data: { '_token' : '{{ csrf_token() }}', 'start_time' : shift_start_time, 'end_time' : shift_end_time, 'user_id' : user_id },
                
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

  </script>
@endsection
