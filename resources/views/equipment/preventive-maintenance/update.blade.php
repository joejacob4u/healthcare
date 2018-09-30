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
                            <label for="is_in_house">Employment Type:</label>
                            {!! Form::select('is_in_house', ['-1' => 'Please select',1 => 'In-House',0 => 'External'], $work_order->is_in_house, ['class' => 'form-control','id' => 'is_in_house']); !!}
                            <span class="help-block">This field is required.</span>
                        </div>
                        <div id="in_house_div" @if($work_order->is_in_house == 1) style="" @else style="display:none;"  @endif>
                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>
                                {!! Form::select('status', ['0' => 'Please select','ongoing' => 'Ongoing','open' => 'Open - Parts on Order','bcm' => 'BCM (Beyond Capable Maintenance) - Major Capital Needs are Required','compliant' => 'Complete and Compliant'], $work_order->status, ['class' => 'form-control','id' => 'status']); !!}
                                <span class="help-block">Required</span>
                            </div>

                            <div class="form-group">
                                <label for="start_time" class="control-label">Start Time</label>
                                <input type="text" class="form-control" id="start_time" name="start_time" value="{{$work_order->start_time}}" required="" title="Time of work initialization" placeholder="Time of work initialization">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label for="end_time" class="control-label">End Time</label>
                                <input type="text" class="form-control" id="end_time" name="end_time" value="{{$work_order->end_time}}" required="" title="Time of work conclusion" placeholder="Time of work conclusion">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label for="parts_on_order" class="control-label">Parts on Order</label>
                                <textarea class="form-control" rows="3" id="parts_on_order" name="parts_on_order" value="{{$work_order->parts_on_order}}"></textarea>
                                <span class="help-block">Required if status is set to 'Open'</span>
                            </div>
                            <div class="form-group">
                                <label for="comment" class="control-label">Comment</label>
                                <textarea class="form-control" rows="3" id="comment" name="comment" value="{{$work_order->comment}}"></textarea>
                                <span class="help-block">Required if status is set to 'BCM'</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="attachment" class="control-label">Attachments</label>
                            {!! HTML::dropzone('attachment','equipments/pm/work_order/'.$work_order->id,'true','true') !!}
                            <span class="help-block"></span>
                        </div>
                        
                        <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                        <button type="submit" class="btn btn-success btn-block">Submit</button>
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

    <script src="{{ asset ("/bower_components/moment/moment.js") }}" type="text/javascript"></script>

    <script>

    $('#is_in_house').change(function(){

        if($(this).val() == 0){
            $('#start_time').val('');
            $('#comment').text('File Upload and Compliant');
            $('#status').val('compliant');
            $('#in_house_div').show();
        }
        else{
            $('#start_time').val('');
            $('#start_time').closest('.help-block').html('');
            $('#end_time').val('');
            $('#status').val('0');
            $('#in_house_div').show();
        }

    });

    $("#start_time,#end_time").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        altFormat: "F j,Y h:i K",
    });

    $("#end_time").focus(function(){
        if(!$("#start_time").val()){
            $('#start_time').focus();
            alert('You will need to set start time first.');

        }

    });


    </script>



@endsection
