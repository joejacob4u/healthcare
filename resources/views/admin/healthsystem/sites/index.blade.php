@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Health Card Organizations Sites')
@section('page_description','Manage HCOs sites here.')

@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Sites for {{$hco->facility_name}}</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/hco/'.$hco->id.'/sites/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add Site</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Site ID #</th>
                        <th>Site Name</th>
                        <th>Site State</th>
                        <th>Site City</th>
                        <th>Site Zip</th>
                        <th>Buildings</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Site ID #</th>
                      <th>Site Name</th>
                      <th>Site State</th>
                      <th>Site City</th>
                      <th>Site Zip</th>
                      <th>Buildings</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                  @foreach($hco->sites as $site)
                    <tr>
                      <td>{{$site->site_id}}</td>
                      <td>{{$site->name}}</td>
                      <td>{{$site->state}}</td>
                      <td>{{$site->city}}</td>
                      <td>{{$site->zip}}</td>
                      <td>{!! link_to('','Buildings',['class' => 'btn-xs btn-info']) !!}</td>
                      <td>{!! link_to('hco/'.$hco->id.'/sites/edit/'.$site->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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
