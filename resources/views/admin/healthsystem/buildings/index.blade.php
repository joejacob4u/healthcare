@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Health Card Organizations Buildings')
@section('page_description','Manage buildings here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Buildings for {{$site->name}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/sites/'.$site->id.'/buildings/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Building</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Building ID #</th>
                        <th>Building Name</th>
                        <th>Building Type</th>
                        <th>Building SqFt</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Building ID #</th>
                      <th>Building Name</th>
                      <th>Building Type</th>
                      <th>Building SqFt</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($site->buildings as $building)
                    <tr>
                      <td>{{$building->building_id}}</td>
                      <td>{{$building->name}}</td>
                      <td>{{$building->occupancy_type}}</td>
                      <td>{{$building->square_ft}}</td>
                      <td>{!! link_to('admin/sites/'.$site->id.'/buildings/edit/'.$building->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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

@endsection
