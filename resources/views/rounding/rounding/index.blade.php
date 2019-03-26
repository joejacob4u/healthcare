@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Roundings for '.session('building_name'))
@section('page_description','Manage roundings here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Existing Roundings for {{session('building_name')}}</h3>
        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        <table id="example" type="custom" class="table table-striped">
                <thead>
                    <tr>
                        <th>Dept</th>
                        <th>Checklist Type</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Evaluate</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Dept</th>
                        <th>Checklist Type</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Evaluate</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($roundings->sortByDesc('date') as $rounding)
                    <tr id="tr-{{$rounding->id}}">
                        <td>{{$rounding->config->department->name}}</td>
                        <td>{{$rounding->config->checklistType->name}}</td>
                        <td>{{$rounding->date->toDayDateTimeString()}}</td>
                        <td>{{ $rounding->config->user->name }}</td>
                        <td>{!! link_to('rounding/'.$rounding->id.'/questions','Evaluate',['class' => 'btn-xs btn-warning']) !!}</td>
                        <td>{{ $rounding->status->name }}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

            {{$roundings->links()}}
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        
      </div>
      <!-- /.box-footer-->
    </div>

@endsection
