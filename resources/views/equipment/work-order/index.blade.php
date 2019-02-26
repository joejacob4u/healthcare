@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Work Orders')
@section('page_description','Preventive Maintenance and Demand Work Orders')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Search for Equipment</h3>

          <div class="box-tools pull-right">
          </div>

        </div>
        <div class="box-body">
          

            <div class="form-group">
                <div class="col-lg-4">
                    {!! Form::select('equipment_id',$equipments->prepend('Please select equipment',0), $value = '', ['class' => 'form-control selectpicker','data-live-search' => "true","data-size" => "false",'id' => 'equipment_id']) !!}
                </div>
                <div class="col-lg-4">
                    {!! Form::text('date_range', $value = '', ['class' => 'form-control','id' => 'date_range','placeholder' => 'Select Date Range']) !!}
                </div>
                <div class="col-lg-4">
                    <button class="btn btn-primary" id="search-button"><span class="glyphicon glyphicon-search"></span> Search</button>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <!-- /.box-footer-->
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Work Orders for <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
          <div class="pull-left"><a href="{{url('equipment/download')}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span> Download</a></div>
        </div>
      </div>
      <div class="box-body">

        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#my-work-orders">My Work Orders</a></li>
          <li><a data-toggle="tab" href="#pm-work-orders">PM Work Orders</a></li>
          <li><a data-toggle="tab" href="#demand-work-orders">Demand Work Orders</a></li>
          <li><a data-toggle="tab" href="#ilsm-assessments">ILSM Assessments</a></li>
        </ul>

        <div class="tab-content">

          <div id="my-work-orders" class="tab-pane fade in active">
            <center><p>Work in Progress</p></center>
          </div>

          <div id="pm-work-orders" class="tab-pane fade">
              <table id="example" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Frequency</th>
                        <th>Date Required</th>
                        <th>User</th>
                        <th>Avg Time Needed / Actual Duration</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Frequency</th>
                        <th>Date Required</th>
                        <th>User</th>
                        <th>Avg Time Needed / Actual Duration</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($pm_work_orders->sortByDesc('work_order_date') as $work_order)
                    @if($work_order->hasInventories())
                    <tr>
                      <td>{{$work_order->equipment->category->name}}</td>
                      <td>{{$work_order->equipment->assetCategory->name}}</td>
                      <td>{{$work_order->equipment->description}}</td>
                      <td>{{$work_order->equipment->frequency}}</td>
                      <td>{{$work_order->work_order_date->toFormattedDateString()}}</td>
                        <td>{{$work_order->baselineDate->user->name}}</td>
                        <td>{{ $work_order->avgDuration() }} ({{$work_order->duration()}}) mins</td>
                      <td>{{$work_order->status()}}</td>
                      <td>{!! link_to('equipment/pm/work-orders/'.$work_order->id.'/inventory','View',['class' => 'btn-xs btn-info']) !!}</td>
                    </tr>
                    @endif
                  @endforeach
                </tbody>
            </table>

            {{ $pm_work_orders->fragment('pm-work-orders')->links() }}

          </div>

          <div id="demand-work-orders" class="tab-pane fade">

              <table id="demand-work-order-table" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Identifier</th>
                        <th>Location</th>
                        <th>Issue</th>
                        <th>Priority</th>
                        <th>Reported At</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Identifier</th>
                        <th>Location</th>
                        <th>Issue</th>
                        <th>Priority</th>
                        <th>Reported At</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($demand_work_orders as $work_order)
                    <tr>
                      <td>{{$work_order->identifier}}</td>
                      <td>{{$work_order->department->name}} ({{$work_order->room->room_number}})</td>
                      <td>{{$work_order->problem->name}} ({{$work_order->trade->name}})</td>
                      <td>{{$work_order->priority->name}}</td>
                      <td>{{$work_order->created_at->setTimezone(session('timezone'))->toDayDateTimeString()}}</td>
                      <td>{{$work_order->status()}} @if($work_order->is_ilsm_probable) <small class="label bg-orange ilsm-probable" data-work-order-id="{{$work_order->id}}"><i class="fa fa-exclamation-triangle"></i> ILSM Probable</small>@elseif($work_order->is_ilsm) <small class="label bg-red is_ilsm" data-work-order-id="{{$work_order->id}}"><i class="fa fa-times-circle"></i> ILSM Required</small> @endif</td>
                      <td>{!! link_to('/equipment/demand-work-orders/'.$work_order->id,'View',['class' => 'btn-xs btn-info']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
          </div>

          <div id="ilsm-assessments" class="tab-pane fade">
            <table id="ilsm-assessment-table" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Demand WO</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Demand WO</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($ilsm_assessments as $ilsm_assessment)
                    <tr>
                      <td>{{$ilsm_assessment->demandWorkOrder->identifier}}</td>
                      <td>@if(!empty($ilsm_assessment->start_time)) $ilsm_assessment->start_time->toFormattedDateString()  @else N/A  @endif</td>
                      <td>@if(!empty($ilsm_assessment->end_time)) $ilsm_assessment->end_time->toFormattedDateString()  @else N/A  @endif</td>
                      <td>{{$ilsm_assessment->status->name}}</td>
                      <td>{!! link_to('/equipment/ilsm-assessment/'.$ilsm_assessment->id,'View',['class' => 'btn-xs btn-info']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            {{ $ilsm_assessments->fragment('ilsm-assessments')->links() }}
          </div>

        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        
      </div>
      <!-- /.box-footer-->
    </div>

        <!-- Edit Modal -->
    <div class="modal fade" id="ilsm-probable-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ILSM Pre-Assessment</h4>
          </div>
          <div class="modal-body">
            <form action="/equipment/ilsm-assessment/pre-assessment" method="post">
              @foreach($ilsm_preassessment_questions as $key => $question)
                <div class="form-group" @if($key != 1) style="display:none;" @endif id="question{{$key}}_div">
                    <label for="ilsm_preassessment_question_{{$key}}">{{$question}}</label>
                    {!! Form::select('ilsm_preassessment_question_answers['.$key.']', ['' => 'Please Select','1' => 'Yes','0' => 'No'], '', ['class' => 'form-control','id' => 'ilsm_preassessment_question_'.$key,'multiple' => false]); !!}
                </div>
              @endforeach

              {!! Form::hidden('ilsm_preassessment_user_id', Auth::user()->id,['id' => 'ilsm_preassessment_user_id']) !!}

              <button type="submit" class="btn btn-success">Submit</button>
              {!! Form::hidden('demand_work_order_id','',['id' => 'demand_work_order_id']) !!}
              {!! csrf_field() !!}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>



  <script>
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover(); 

      $("#date_range").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        mode: "range",
    });


    
  });

  $('#search-button').click(function(){

      var equipment_id = $('#equipment_id').val();
      var date_range = $('#date_range').val();

      var date_ranges = date_range.split('to');

      if(equipment_id > 0 && date_range){
        window.location.href = "/equipment/pm/work-orders?equipment_id="+equipment_id+"&from="+date_ranges[0].trim()+"&to="+date_ranges[1].trim(); 
      }
    });


  $('.ilsm-probable').click(function(){
    $('#ilsm-probable-modal #demand_work_order_id').val($(this).attr('data-work-order-id'));
    $('#ilsm-probable-modal').modal('show');
  });

  $('#ilsm-probable-modal #ilsm_preassessment_question_1').change(function(){
    if($(this).val() == 0){
      $('#question2_div').show();
    }
    else
    {
      $('#question2_div').hide();
    }
  });

  $('#ilsm-probable-modal #ilsm_preassessment_question_2').change(function(){
    if($(this).val() == 1){
      $('#question3_div').show();
    }
    else
    {
      $('#question3_div').hide();
    }
  });



    
  </script>
@endsection
