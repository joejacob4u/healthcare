@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Health Care Organizations')
@section('page_description','Manage HCOs here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">HCOs for {{$health_system->healthcare_system}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/healthsystem/'.$health_system->id.'/hco/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add HCO</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>HCO</th>
                        <th>Accreditation</th>
                        <th>Sites</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>HCO</th>
                      <th>Accreditation</th>
                      <th>Sites</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($hcos as $hco)
                    <tr>
                      <td><strong>#{{$hco->hco_id}}</strong> - {{$hco->facility_name}}</td>
                      <td>@foreach($hco->accreditations as $accreditation) {{$accreditation->name}},  @endforeach</td>
                      <td>{!! link_to('admin/hco/'.$hco->id.'/sites','Sites',['class' => 'btn-xs btn-info']) !!}</td>
                      <td>{!! link_to('admin/healthsystem/'.$health_system->id.'/hco/edit/'.$hco->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{url('admin/healthsystem')}}" class="btn btn-primary btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
      </div>
      <!-- /.box-footer-->
    </div>

@endsection
