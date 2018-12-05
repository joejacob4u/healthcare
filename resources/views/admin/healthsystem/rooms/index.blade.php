@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Health Care Organizations Buildings')
@section('page_description','Manage buildings here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Rooms for {{$department->name}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/departments/'.$department->id.'/rooms/create')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Room</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Room #</th>
                        <th>Room Type</th>
                        <th>Clinical</th>
                        <th>Square Ft</th>
                        <th>Bar Code</th>
                        <th>Sprinkled %</th>
                        <th>Beds</th>
                        <th>Unused Space Sq Ft</th>
                        <th>Operating Rooms</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Room #</th>
                        <th>Room Type</th>
                        <th>Clinical</th>
                        <th>Square Ft</th>
                        <th>Bar Code</th>
                        <th>Sprinkled %</th>
                        <th>Beds</th>
                        <th>Unused Space Sq Ft</th>
                        <th>Operating Rooms</th>
                        <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($department->rooms as $room)
                    <tr>
                      <td>{{$room->room_number}}</td>
                      <td>{{$room->room_type}}</td>
                      <td>{{$room->is_clinical}}</td>
                      <td>{{$room->square_ft}}</td>
                      <td>{{$room->bar_code}}</td>
                      <td>{{$room->sprinkled_pct}}</td>
                      <td>{{$room->beds}}</td>
                      <td>{{$room->unused_space_sq_ft}}</td>
                      <td>{{$room->operating_rooms}}</td>
                      <td>{!! link_to('admin/departments/'.$department->id.'/rooms/'.$room->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{url('admin/sites/'.$department->building->site->id.'/buildings/'.$department->building->id.'/departments')}}" class="btn btn-primary btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
      </div>
      <!-- /.box-footer-->
    </div>

@endsection
