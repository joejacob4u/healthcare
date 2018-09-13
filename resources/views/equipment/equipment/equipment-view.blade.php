@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Equipments')
@section('page_description','Manage equipments here')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Equipments for <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
          <div class="pull-left"><a href="{{url('equipment/download')}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span> Download</a></div>
        </div>
      </div>
      <div class="box-body">
                <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Eq ID Number</th>
                        <th>Room</th>
                        <th>More Info</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Asset Category</th>
                        <th>Description</th>
                        <th>Eq ID Number</th>
                        <th>Room</th>
                        <th>More Info</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipments as $equipment)
                    <tr>
                      <td>{{$equipment->name}}</td>
                      <td>{{$equipment->category->name}}</td>
                      <td>{{$equipment->assetCategory->name}}</td>
                      <td>{{$equipment->description}}</td>
                      <td>{{$equipment->identification_number}}</td>
                      <td>{{$equipment->room->room_number}}</td>
                      
                      @php
                        $html = '<strong>Maintenance Requirement : </strong>'.$equipment->maintenanceRequirement->name.'<br/><strong>Manufacturer : </strong>'.$equipment->manufacturer.'<br/><strong>Model Number : </strong>'.$equipment->model_number.'<br/><strong>Serial Number : </strong>'.$equipment->serial_number.'<br/><strong>Installation : </strong>'.$equipment->manufacturer_date;
                      @endphp

                      <td>{{link_to('#info-'.$equipment->id,'More Info', ['class' => 'btn-xs btn-primary','data-toggle' => 'popover','title' => 'More Info for '.$equipment->name,'data-placement' => 'left','data-trigger' => 'click','data-html' => "true",'data-content' => $html] )}}</td>
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
  });
  </script>
@endsection
