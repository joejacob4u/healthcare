@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Equipments')
@section('page_description','Preventive Maintenance')

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
        <h3 class="box-title">Preventive Maintenance View for Equipments in <strong>{{session('building_name')}}</strong></h3>

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
                        <th>View</th>
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
                        <th>View</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($work_orders as $work_order)
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
                    </tr>

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

      $("#date_range").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        mode: "range",
    });

      $('table').DataTable( {
        "order": [[ 5, "desc" ],[6,"desc"]]
    } );

    
  });

  $('#search-button').click(function(){

      var equipment_id = $('#equipment_id').val();
      var date_range = $('#date_range').val();

      var date_ranges = date_range.split('to');

      if(equipment_id > 0 && date_range){
        window.location.href = "/equipment/pm/work-orders?equipment_id="+equipment_id+"&from="+date_ranges[0].trim()+"&to="+date_ranges[1].trim(); 
      }
    });
  </script>
@endsection
