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
    <li><a href="{{url('equipment/work-orders/'.$work_order->equipment->assetCategory->systemTier->id)}}#pm-work-orders">Work Orders</a></li>
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
    </div><br/>

    <div class="row">
        <div class="col-sm-6"><strong>Department : </strong> @foreach($work_order->equipment->inventories as $inventory){{$inventory->department->name}}@endforeach</div>
        <div class="col-sm-6"><strong>Room : </strong> @foreach($work_order->equipment->inventories as $inventory){{$inventory->room->room_number}}@endforeach</div>
    </div>

</div>

@if(count($work_order->equipment->assetCategory->eops) > 0)

<div class="callout callout-info">
    <h4>EOP</h4>

    @foreach($work_order->equipment->assetCategory->eops as $eop)

    <a href="#" class="list-group-item active list-group-item-info">
        <h4>{{$eop->standardLabel->label}} - EOP : {{$eop->name}}</h4>
        <p>{{$eop->text}}</p>
    </a>

    @endforeach
</div>


@endif

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Preventive Maintenance View for Equipment in <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Inventory</th>
                        <th>Avg Time Needed / Actual Duration</th>
                        <th>Times</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Status</th>
                        <th>Inventory</th>
                        <th>Avg Time Needed / Actual Duration</th>
                        <th>Times</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($work_order->workOrderInventories as $work_order_inventory)
                    <tr>
                      <td>{{$work_order_inventory->workOrderStatus()}}</td>
                      <td>{{$work_order_inventory->inventory->name}}<button data-inventory = "{{json_encode($work_order_inventory->inventory)}}" data-room="{{$work_order_inventory->inventory->room->room_number}}" class="btn btn-link btn-xs inventory-info"><span class="glyphicon glyphicon-info-sign"></span></button></td>
                      <td>{{$work_order_inventory->avgTime()}} ({{$work_order_inventory->duration()}}) mins</td>
                      <td><button onclick="openTimesModal({{$work_order_inventory->id}})" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-time"></span> Input Status / Times</button></td>
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
          <div class="form-group">
            <label for="usr">Inventory:</label>
            {!! Form::select('work_order_inventory_id', [], '', ['class' => 'form-control selectpicker','id' => 'work_order_inventory_id','multiple' => true]); !!}
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

    <!-- Times Modal -->
  <div class="modal fade" id="times-modal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Times for Inventory Maintenance</h4>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group row">
                <div class="col-xs-3">
                    <label for="ex1">Status</label>
                    {!! Form::select('equipment_work_order_status_id', $work_order_statuses->prepend('Please Select',''), '', ['class' => 'form-control','id' => 'equipment_work_order_status_id']); !!}
                </div>
                <div class="col-xs-3">
                    <label for="ex2">Start Time</label>
                    {!! Form::text('start_time', '', ['class' => 'form-control date','data-inventory-id' => $work_order_inventory->id,'data-field' => 'start_time','id' => 'start_time']) !!}
                </div>
                <div class="col-xs-3">
                    <label for="ex3">End Time</label>
                    {!! Form::text('end_time', '', ['class' => 'form-control date','data-inventory-id' => $work_order_inventory->id,'data-field' => 'end_time','id' => 'end_time']) !!}
                </div>
                <div class="col-xs-3">
                    <label for="ex3">Comment</label>
                    {!! Form::text('comment', '', ['class' => 'form-control comment','data-inventory-id' => $work_order_inventory->id,'data-field' => 'comment','id' => 'comment']) !!}
                </div>
            </div>

            {!! Form::hidden('equipment_work_order_inventory_id', '',['id' => 'equipment_work_order_inventory_id']) !!}
            
            <button type="button" onclick="saveTime()" class="btn btn-success">Add Time</button>
         </form>

         <br>

         <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Existing Times</h3>
            </div>
            
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            Footer
            </div>
            <!-- /.box-footer-->
         </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>

  <!--End of Times Modal -->




  <script>

  var work_order_id = '{{$work_order->id}}';
  var timeoutId;
  var user_id = '{{Auth::user()->id}}';

  $(document).ready(function(){
      
      $('[data-toggle="popover"]').popover(); 

      inventory_time_pickers = $(".date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
        altInput: true,
        altFormat: "M j, Y h:i K",
        onOpen : function(selectedDates, dateStr, instance) {
            if(instance.element.dataset.field == 'end_time')
            {
                instance.setDate($("#start_time").val());
            }
        },

        onClose: function(selectedDates, dateStr, instance) {
            if(instance.element.dataset.field == 'end_time')
            {
                if(moment(dateStr).isBefore($("#start_time").val()))
                {
                    instance.clear();
                    alert('End time has to be a value earlier than start time.');
                }
            }
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
      var inventories = $('#work_order_inventory_id').val();
      console.log(inventories);

      if(shift_start_time && shift_end_time)
      {
            $.ajax({
                type: 'POST',
                url: '{{ url("equipment/pm/work-orders/".$work_order->id."/shift/add") }}',
                data: { '_token' : '{{ csrf_token() }}', 'start_time' : shift_start_time, 'end_time' : shift_end_time, 'user_id' : user_id, 'work_order_inventory_id' : inventories },
                
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

  function openTimesModal(work_order_inventory_id)
  {
        $('#times-modal #equipment_work_order_inventory_id').val(work_order_inventory_id);

        populateTimes(work_order_inventory_id);

        $('#times-modal').modal('show');
  }

    function saveTime()
    {
        var is_form_verified = true;
        var work_order_inventory_id = $('#times-modal #equipment_work_order_inventory_id').val();

        $("#times-modal .form-control").each(function() {

            if(!this.value) {
                alert("All fields are required!");
                is_form_verified = false;
                return 0;
            }
        });

        if(is_form_verified)
        {
            $.ajax({
                type: 'POST',
                url: '{{ url("work-orders/".$work_order->id."/inventory/") }}/'+work_order_inventory_id+'/time',
                data: { 
                    '_token' : '{{ csrf_token() }}', 
                    'start_time' : $('#times-modal #start_time').val(), 
                    'end_time' : $('#times-modal #end_time').val(), 
                    'comment' : $('#times-modal #comment').val(),
                    'equipment_work_order_status_id' : $('#times-modal #equipment_work_order_status_id').val(),
                    'user_id' : user_id
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
                        $('#times-modal #comment').val('');
                        $('#times-modal #equipment_work_order_status_id').val('');
                        populateTimes(work_order_inventory_id);

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

    function populateTimes(work_order_inventory_id)
    {
        $.ajax({
            type: 'POST',
            url: '{{ url("equipment/pm/work-orders/".$work_order->id."/inventory/fetch-times") }}',
            data: { '_token' : '{{ csrf_token() }}', 'work_order_inventory_id' : work_order_inventory_id },
            
            beforeSend:function()
            {
                // dialog = bootbox.dialog({
                //     message: '<p class="text-center">Fetching Times</p>',
                //     closeButton: false
                // });

            },
            
            success:function(data)
            {
                if(data.status == 'success')
                {
                    $('#times-modal table tbody').html('');

                    var html = '';


                    $.each(data.work_order_inventory_times, function(index, value) {

                        var delete_button_state = (value.user.id == user_id) ? '' : 'disabled';

                        html += `<tr id="${value.id}_time_tr">
                                    <td><small class="label bg-blue"><i class="fa fa-user"></i> ${value.user.name}</small> ${value.work_order_status.name}</td>
                                    <td>${moment(value.start_time).format("MMM D YYYY, h:mm a")}</td>
                                    <td>${moment(value.end_time).format("MMM D YYYY, h:mm a")}</td>
                                    <td>${value.comment}</td>
                                    <td><button ${delete_button_state} class="btn btn-danger btn-xs" onclick="deleteInventoryTime('${value.id}','${work_order_inventory_id}')"><span class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>`;
                    });

                    $('#times-modal table tbody').append(html);

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

    function deleteInventoryTime(inventory_time_id,work_order_inventory_id)
    {
        bootbox.confirm("Are you sure you want to delete this inventory time?", function(result)
        { 
            if(result == 1)
            {
                $.ajax({
                    type: 'POST',
                    url: '/work-orders/'+work_order_id+'/inventory/'+work_order_inventory_id+'/time/delete',
                    data: { '_token' : '{{ csrf_token() }}','inventory_time_id': inventory_time_id},
                    beforeSend:function()
                    {
                        $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data)
                    {
                        if(data.status == 'success')
                        {
                            $('#'+inventory_time_id+'_time_tr').remove();
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

    function openShift()
    {
        $.ajax({
            type: 'POST',
            url: '{{ url("equipment/pm/work-orders/".$work_order->id."/shift/inventories") }}',
            data: { '_token' : '{{ csrf_token() }}'},
            
            beforeSend:function()
            {
                dialog = bootbox.dialog({
                    message: '<p class="text-center">Loading</p>',
                    closeButton: false
                });

            },
            
            success:function(data)
            {
                if(data.status == 'success')
                {
                    var html = '';

                    $('#shift-modal #work_order_inventory_id').html('');

                    $.each(data.inventories, function(index, value) {
                        var is_compliant = false;
                        
                        $.each(value.work_order_inventory_times, function(wo_index, wo_value) {
                            if(wo_value.equipment_work_order_status_id == 1){
                                is_compliant = true;
                            }
                        });

                        if(!is_compliant)
                        {
                            html += `<option value="${value.id}">${value.inventory.name}</option>`;
                        }

                    });

                    $('#shift-modal #work_order_inventory_id').append(html);

                    $('#work_order_inventory_id').selectpicker('refresh');

                    dialog.modal('hide');
                    $('#shift-modal').modal('show');
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

    $("#times-modal").on('hide.bs.modal', function(){
        location.reload();
    });



  </script>
@endsection
