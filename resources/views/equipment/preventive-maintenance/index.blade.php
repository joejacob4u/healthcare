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

                      <td>{{$work_order->status}}</td>

                      @if($work_order->status == 'pending_initialization')
                        <td>{{link_to('equipment/pm/work-orders/update/'.$work_order->id,'Start Work Order', ['class' => 'btn-xs btn btn-primary'] )}}</td>
                      @elseif($work_order->status == 'ongoing')
                        <td>{{link_to('equipment/pm/work-orders/update/'.$work_order->id,'Resume Work Order', ['class' => 'btn-xs btn btn-warning'] )}}</td>
                      @else
                        <td>{{link_to('equipment/pm/work-orders/update/'.$work_order->id,'Update Work Order', ['class' => 'btn-xs btn btn-info'] )}}</td>
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

      $('table').DataTable( {
        "order": [[ 5, "desc" ],[6,"desc"]]
    } );
  });
  </script>
@endsection
