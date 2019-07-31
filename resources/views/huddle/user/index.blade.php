@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Huddles')
@section('page_description','Manage huddles here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Huddles for {{session('healthsystem_name')}}</h3>
        <div class="box-tools pull-right">
          <a href="{{url('huddle/create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Initiate Huddle</a>
        </div>
      </div>
      <div class="box-body">
        <table id="config-table" class="table table-striped" type="custom">
                <thead>
                    <tr>
                        <th>Care Team</th>
                        <th>Date</th>
                        <th>Recorder of Data</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Care Team</th>
                        <th>Date</th>
                        <th>Recorder of Data</th>
                        <th>View</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($huddles as $huddle)
                    <tr id="tr-{{$huddle->id}}">
                        <td>{{$huddle->careTeam->name}}</td>
                        <td>{{$huddle->date->toDayDateTimeString()}}</td>
                        <td>{{$huddle->recorderOfData->name}}</td>
                        <td>{!! link_to('huddle/'.$huddle->id,'View',['class' => 'btn-xs btn-warning']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            {{$huddles->links()}}
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        Footer
      </div>
      <!-- /.box-footer-->
    </div>

  </div>

@endsection
