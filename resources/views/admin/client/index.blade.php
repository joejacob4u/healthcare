@extends('layouts.app')

@section('head')
@parent

@endsection
@section('content')
@include('layouts.partials.success')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">HCO Clients</h3>

        <div class="box-tools pull-right">
          <a href="{{url('admin/clients/add')}}" type="button" class="btn btn-block btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add HCO Client</a>
        </div>
      </div>
      <div class="box-body">
        <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>HCO ID</th>
                        <th>Facility Name</th>
                        <th>Phone</th>
                        <th>Admin</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>HCO ID</th>
                      <th>Facility Name</th>
                      <th>Phone</th>
                      <th>Admin</th>
                      <th>Edit</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{$client->hco_id}}</td>
                        <td>{{$client->facility_name}}</td>
                        <td>{{$client->admin_phone}}</td>
                        <td>{{$client->admin_email}}</td>
                        <td>{!! link_to('admin/clients/edit/'.$client->id,'Edit',['class' => 'btn-xs btn-warning']) !!}</td>
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
