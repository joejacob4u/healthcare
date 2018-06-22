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
        <h3 class="box-title">Buildings for {{$site->name}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('sites/'.$site->id.'/buildings/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Building</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Building ID #</th>
                        <th>Building Name</th>
                        <th>Accreditation</th>
                        <th>Occupancy Type</th>
                        <th>Departments</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Building ID #</th>
                      <th>Building Name</th>
                      <th>Accreditation</th>
                      <th>Occupancy Type</th>
                      <th>Departments</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($site->buildings as $building)
                    <tr>
                      <td>{{$building->building_id}}</td>
                      <td>{{$building->name}}</td>
                      <td>@foreach($building->accreditations as $accreditation) {{$accreditation->name}},  @endforeach</td>
                      <td>{{strtoupper(implode(' ',explode('_',$building->occupancy_type)))}}</td>
                      <td>{!! link_to('sites/'.$site->id.'/buildings/'.$building->id.'/departments','Departments',['class' => 'btn-xs btn-info']) !!}</td>
                      <td>{!! link_to('sites/'.$site->id.'/buildings/edit/'.$building->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{url('hco/'.$site->hco->id.'/sites')}}" class="btn btn-primary btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
      </div>
      <!-- /.box-footer-->
    </div>

@endsection
