@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Departments')
@section('page_description','Manage departments here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Departments for {{$building->name}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('buildings/'.$building->id.'/departments/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Department</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Business Unit Cost Center</th>
                        <th>Rooms</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Department Name</th>
                      <th>Business Unit Cost Center</th>
                      <th>Rooms</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($building->departments as $department)
                    <tr>
                      <td>{{$department->name}}</td>
                      <td>{{$department->business_unit_cost_center}}</td>
                      <td>{!! link_to('buildings/'.$building->id.'/departments/'.$department->id.'/rooms','Rooms',['class' => 'btn-xs btn-info']) !!}</td>
                      <td>{!! link_to('buildings/'.$building->id.'/departments/'.$department->id.'/edit','Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{url('sites/'.$building->site->id.'/buildings')}}" class="btn btn-primary btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
      </div>
      <!-- /.box-footer-->
    </div>

@endsection
