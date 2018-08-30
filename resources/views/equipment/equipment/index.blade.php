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
        <h3 class="box-title">Existing Equipments for <strong>{{session('building_name')}}</strong></h3>

        <div class="box-tools pull-right">
          <a href="{{url('equipment/create')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Equipment</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>Room Number</th>
                        <th>Eq ID Number</th>
                        <th>USL Score</th>
                        <th>Mission Criticality Score</th>
                        <th>EM Number Score</th>
                        <th>EM Rating Score</th>
                        <th>Adjusted EM Rating Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Serial Number</th>
                        <th>Room Number</th>
                        <th>Eq ID Number</th>
                        <th>USL Score</th>
                        <th>Mission Criticality Score</th>
                        <th>EM Number Score</th>
                        <th>EM Rating Score</th>
                        <th>Adjusted EM Rating Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($equipments as $equipment)
                    <tr>
                      <td>{{$equipment->name}}</td>
                      <td>{{$equipment->serial_number}}</td>
                      <td>{{$equipment->room->room_number}}</td>
                      <td>{{$equipment->identification_number}}</td>
                      <td><span class="label label-default">{{$equipment->USLScore()}}</span></td>
                      <td><span class="label label-default">{{$equipment->missionCriticalityRatingScore()}}</span></td>
                      <td><span class="label label-default">{{$equipment->EMNumberScore()}}</span></td>
                      <td><span class="label label-default">{{$equipment->EMRatingScore()}}</span></td>
                      <td><span class="label label-default">{{$equipment->AdjustedEMRScore()}}</span></td>
                      <td>{{link_to('equipment/edit/'.$equipment->id,'Edit', ['class' => 'btn-xs btn-warning'] )}}</td>
                      <td>{{link_to('','Delete', ['class' => 'btn-xs btn-danger'] )}}</td>
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
     
  });
  </script>

@endsection
